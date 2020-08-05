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


use AppBundle\Exceptions\SecurityException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\TwUser;


/**
 * PasswordController controller
 * @author Mario Hidalgo <neossoftware@gmail.com>
 */
class PasswordController extends FOSRestController
{

    /**
     *
     * @Rest\Post("/api/requestResetPwd")
     */
    public function requestResetPwd(Request $request)
    {
        $response = null;

        //get info
        $username = $request->get('email');

        $userService = $this->get('userService');

        $userService->sendTokenResetPwd($username);

        return "ok";

    }
    /**
     *
     * @Rest\Post("/api/validateUrl")
     */
    public function validateUrl(Request $request) {
        //get info
        $username = $request->get('email');
        $password = $request->get('password');
        $hash = $request->get('hash');

        //first validate if the user exists

        $userService = $this->get('userService');

        $twUser = new TwUser();
        $twUser->setEmail($username);
        $twUser->setPwd($password);
        $twUser->setHashreset($hash);

        try {
            $response = $userService->validateTokenChangePwd($twUser);

        } catch (SecurityException $e) {

            $response = array(
                "code" => 1,
                "message" => $e->getMessage()
            );

        }

        return $response;

    }

    /**
     *
     * @Rest\Post("/api/changePassword")
     */
    public function changePassword(Request $request)
    {
        //get info
        $username = $request->get('email');
        $password = $request->get('password');
        $hash = $request->get('hash');

        //first validate if the user exists

        $userService = $this->get('userService');
        $mailService = $this->get('mailService');

        $twUser = new TwUser();
        $twUser->setEmail($username);
        $twUser->setPwd($password);
        $twUser->setHashreset($hash);

        try {
            $response = $userService->resetPassword($twUser);
            $mailService->notifyChangePassword($twUser);
        } catch (SecurityException $e) {

            $response = array(
                "code" => 1,
                "message" => $e->getMessage()
            );

        }

        return $response;

    }

}