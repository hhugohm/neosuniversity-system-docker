<?php

/*
 * This file is part of the NeosUniversity Software.
 *
 * (c) Neossoftware Corporation
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Exceptions\UserExistsException;
use AppBundle\Entity\TwUser;


class SignUpController extends FOSRestController
{

    /**
     *
     * @Rest\Post("/api/signup")
     */
    public function signUp(Request $request)
    {
        $response = null;

        //get info
        $username = $request->get('email');
        $password = $request->get('password');
        $name = $request->get('name');

        //first validate if the user exists

        $userService = $this->get('userService');
        $mailService = $this->get('mailService');

        $twUser = new TwUser();
        $twUser->setEmail($username);
        $twUser->setUsername($username);
        $twUser->setPwd($password);
        $twUser->setCompletename($name);
        $twUser->setRolid(1);


        try {


            $response = $userService->addUser($twUser);

            $mailService->notifyNewUser($twUser);


        } catch (UserExistsException $e) {

            $response = array(
                "code" => 1,
                "message" => "El correo  " . $username . " ya se encuentra registrado."
            );

        }


        return $response;
    }


}
