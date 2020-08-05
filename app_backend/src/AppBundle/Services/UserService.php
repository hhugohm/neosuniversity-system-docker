<?php

/*
 * This file is part of the NeosUniversity Software.
 *
 * (c) Neossoftware Corporation
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Services;

use AppBundle\Exceptions\SecurityException;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\TwUser;
use AppBundle\Security\Bcrypt;
use AppBundle\Model\User;
//use Firebase\JWT\JWT;
use AppBundle\Exceptions\UserNotFoundException;
use AppBundle\Exceptions\UserExistsException;
use Psr\Log\LoggerInterface;
use \stdClass;

/**
 *  UserService
 * @author Mario Hidalgo aka neossoftware
 **/
class UserService
{


    /***
     *entityManager es el objeto para poder tener acceso a la BD por medio de ORM
     */
    private $entityManager = null;
    private $logger = null;
    private $securityService = null;
    private $mailService = null;

    /**
     * Constructor injects entitymanager and Logger
     **/
    public function __construct(EntityManager $entityManager, LoggerInterface $logger,
                                SecurityService $securityService,
                                MailService $mailService)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->securityService = $securityService;
        $this->mailService = $mailService;
    }

    /**
     *get user by mail
     **/
    function getUserByMail($mail)
    {
        $user = $this->entityManager->find('AppBundle:TwUser', $mail);
        return $user;
    }

    /**
     * Update User
     **/
    function sendTokenResetPwd($mail)
    {
        $em = $this->entityManager;
        $tw_user = $em->find('AppBundle:TwUser', $mail);
        //si encontro el usuario a resetear
        if (!is_null($tw_user)) {
            $hash = $this->securityService->randHash();
            $this->logger->debug('Hash: ' . $hash);
            $tw_user->setHashreset($hash);
            //envia el correo electronico para notificar al usuario
            $this->mailService->notifyResetPassword($tw_user);

            $em->flush();
        }

        $response = array(
            "code" => 0,
            "message" => "Process is done"
        );

        return $response;

    }

    /**
     * return if pwd is correct
     */
    function validatePwd($mail, $pwd)
    {

        $tw_user = $this->getUserByMail($mail); //get user

        if ($tw_user === NULL) {
            throw new UserNotFoundException('User is not found');
        }

        return Bcrypt::checkPassword($pwd, $tw_user->getPwd());


    }

    /**
     *  create token jwt for client
     **/
    function createToken($mail)
    {


        // $tw_user = $userService->getUserByMail($username);

        //$logger->debug('tw_user->'.$tw_user->getUsername());

        $tw_user = $this->getUserByMail($mail); //get user

        //$user = new User();
        $user = new stdClass;

        $user->iat = time();
        $user->exp = time() + (30 * 24 * 60 * 60); //30  dias  de sesion
        //$user->exp = time() + (60*2); //2 min de sesion para pbas
        $user->mail = $mail;
        $user->name = $tw_user->getCompletename();
        $user->rol = $tw_user->getRolid();

        //firma metodo
        //encode($payload, $key, $alg = 'HS256', $keyId = null, $head = null
        $jwt = \JWT::encode($user, ''); //llave vacia

        $this->logger->debug('jwt: ' . $jwt);

        $response = array(
            "code" => 0,
            "message" => "Authenticated",
            "response" => array(
                "token" => $jwt
            )

        );

        return $response;

    }

    function validateTokenChangePwd(TwUser $user, TwUser $user_db = NULL) {

        if ($user_db ===NULL) {
            $em = $this->entityManager;
            $user_db = $em->find('AppBundle:TwUser', $user->getEmail());
        }

        if ($user_db === NULL) {
            throw new SecurityException('Link de cambio de password incorrecto (1128)');
        }

        //validate hash
        if ($user_db->getHashreset() !== $user->getHashreset()) {
            throw new SecurityException('Link de cambio de password incorrecto (1129)');
        }

        if ($user_db->getHashreset() ===NULL || $user_db->getHashreset()==='') {
            throw new SecurityException('Link de cambio de password incorrecto (1130)');
        }

        return $response = array(
            "code" => 0,
            "message" => "Hash correcto"
        );

    }

    /**
     * Metodo para resetear un password de un usario
    **/
    function resetPassword(TwUser $user) {
        $em = $this->entityManager;
        $user_db = $em->find('AppBundle:TwUser', $user->getEmail());

       $this->validateTokenChangePwd($user, $user_db);

        //encrypt password
        $pwdHash = Bcrypt::hashPassword($user->getPwd());
        $user_db->setPwd($pwdHash); //setea el nuevo pwd al usuario de BD
        $user_db->setHashreset(''); //inicializa el hash para que no pueda ser reseteado nuevamente el pwd
        $em->flush(); //guarda los cambios


        return $response = array(
            "code" => 0,
            "message" => "Se realizo el cambio de password de forma exitosa"
        );

    }

    /**
     * add new User to DB
     */
    function addUser(TwUser $user)
    {

        //validate if user exists in database

        $tw_userdb = $this->getUserByMail($user->getEmail()); //get user

        //the user exists it is not possible add the user
        if ($tw_userdb !== NULL) {
            throw new UserExistsException('El usuario existe en la BD');
        }


        //encrypt password
        $pwdHash = Bcrypt::hashPassword($user->getPwd());
        $user->setPwd($pwdHash);

        //save the information
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $response = array(
            "code" => 0,
            "message" => "El usuario se dió de alta exitosamente, es posible ingresar a la aplicación"
        );


    }


}
