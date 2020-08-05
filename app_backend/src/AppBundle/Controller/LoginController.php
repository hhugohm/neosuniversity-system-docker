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
use AppBundle\Exceptions\UserNotFoundException;



/**
 * Login controller
 * @author Mario Hidalgo <neossoftware@gmail.com>
 */
class LoginController extends FOSRestController
{

  /**
   * @Rest\Post("/api/login")
   */
  public function login(Request $request)
  {

    $response =  null;

  	//get info
    $username = $request->get('email');
    $password = $request->get('password');

    $logger = $this->get('logger');

    $logger ->debug('usuario: '.$username.' pwd: '.$password);

    $userService = $this->get('userService');
    try {

      if ($userService->validatePwd($username,$password)) {

        $response = $userService->createToken($username);

      } else {

        $response = array(
          "code" => 1 ,
          "message" => "Usuario o password incorrecto"    
          );

      } 
    }catch(UserNotFoundException $e) {
        $response = array(
          "code" => 1 ,
          "message" => "Usuario o password incorrecto"    
          );
    }

    return $response;



  }

}
