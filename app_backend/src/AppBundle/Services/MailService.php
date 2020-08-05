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

use Psr\Log\LoggerInterface;
use AppBundle\Entity\TwUser;
use AppBundle\Model\Mail;


/**
 *
 * Clase que envia correos por funcionalidad
 * @author Mario Hidalgo M (neossoftware)
 *
 */
class MailService
{

    private $logger = null;

    const MAIL_FROM = 'neosuniversity@gmail.com';
    const PWD_FROM = 'N30sdiscom18'; //encriptar el pwd
    const NAME_FROM = 'NeosUniversity';
    const SMTP_SERVER = 'smtp.googlemail.com';
    const PORT_SERVER = 465;
    const SECURITY = 'ssl';

    /*
    **
    * Constructor injects entitymanager and Logger
    **/
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /*
     * Llena el bean de mail
     *
     * @return Mail mail
     * */
    function fillBasicMail(TwUser $user)
    {

        $mail = new Mail();
        $mail->setMailTo($user->getEmail())
            ->setNameTo($user->getCompletename());

        return $mail;
    }

    /**
    * Agrega un valor al template HTML
     */
    function addValueTemplate($expression,$value,$template) {
        $message = str_replace($expression,$value,$template);
        return $message;
    }

    /**
     * Notifica a un usuario para poder resetear el password
     */
    function notifyResetPassword($user) {
        $mail = $this->fillBasicMail($user);
        $to = $mail->getNameTo();
        $template = file_get_contents('resetPwd.html', FILE_USE_INCLUDE_PATH);
        $message = $this->addValueTemplate('{{userName}}',$to,$template);
        $email_encoded = urlencode($user->getEmail());
        $link = "https://www.neosuniversity.com/platform/ng/#/access/resetpwd/".$email_encoded."/".$user->getHashreset();
        $message = $this->addValueTemplate('{{link}}',$link,$message);
        $message = $this->addValueTemplate('{{linkStr}}',$link,$message);

        $mail->setSubject("Reseteo de Password")
            ->setMessage($message);
        $this->sendMail($mail);
    }

    /**
     * Metodo que notifica al usuario que el password se cambio de forma exitosa
     */
    function notifyChangePassword(TwUser $user) {
        $subject ='Cambio de password exitoso';
        $template = file_get_contents('changePwdSuccess.html', FILE_USE_INCLUDE_PATH);
        $message = $this->addValueTemplate('{{userName}}',$user->getCompletename(),$template);
        $link = "https://www.neosuniversity.com/platform/ng/#/";
        $message = $this->addValueTemplate('{{link}}',$link,$message);
        $this->prepareMail($user,$subject,$message); //send the email
    }

    /***
     * Envia la notificacion de bienvenida a neosuniversity
     * @param $user
     **/
    function notifyNewUser(TwUser $user)
    {
        $mail = $this->fillBasicMail($user);
        $to = $mail->getNameTo();
        $template = file_get_contents('new_user_resp.html', FILE_USE_INCLUDE_PATH);
        $message = $this->addValueTemplate('{{userName}}',$to,$template);
       // $link = "http://127.0.0.1:8080/src/#/";
        //$message = $this->addValueTemplate('{{link}}',$link,$message);
        $mail->setSubject("Bienvenido a NeosUniversity")
            ->setMessage($message);
        $this->sendMail($mail);
    }

    /**
     *  Metodo comun para poder enviar un correo electronico
    */
    function prepareMail(TwUser $user, $subject, $message) {
        $mail = $this->fillBasicMail($user);
        $to = $mail->getNameTo();
        $mail->setSubject($subject)
            ->setMessage($message);
        $this->sendMail($mail);
    }

    /**
     * @param  Mail $mail
     */
    function sendMail(Mail $mail)
    {
        $errors = array();

        $transport = \Swift_SmtpTransport::newInstance(MailService::SMTP_SERVER, MailService::PORT_SERVER, MailService::SECURITY)
            ->setUsername(MailService::MAIL_FROM)
            ->setPassword(MailService::PWD_FROM);


        $mailer = \Swift_Mailer::newInstance($transport);
        $message = \Swift_Message::newInstance($mail->getSubject())
            ->setFrom(array(MailService::MAIL_FROM => MailService::NAME_FROM))
            ->setTo(array($mail->getMailTo() => $mail->getNameTo()));

        $message->setBody($mail->getMessage(), "text/html");
        if (!$mailer->send($message, $errors)) {
            foreach ($errors as $err) {
                $this->logger->debug("Error al enviar el correo: " . $err);
            }
        }

    }


}