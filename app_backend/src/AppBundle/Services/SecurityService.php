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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use AppBundle\Exceptions\SecurityException;
use Exception;

/**
 * SecurityService
 * @author Mario Hidalgo <neossoftware@gmail.com>
 *
 */
class SecurityService
{


    private $logger = null;


    /**
     * Constructor injects entitymanager and Logger
     **/
    public function __construct(LoggerInterface $logger)
    {

        $this->logger = $logger;
    }


    /**
     *
     * validate
     **/
    function validateToken(Request $request)
    {

        $response = null;
        $token = null;

        //get header
        $authorization = $request->headers->get('Authorization');


        list($jwt) = sscanf($authorization, 'Bearer %s');

        if ($jwt) {


            $jwt = trim($jwt, '"');

            $this->logger->debug($jwt);

            try {

                $token = \JWT::decode($jwt);

            } catch (Exception $e) {

                throw new SecurityException($e->getMessage());

            }

            $this->logger->debug("El valor del token es:" . $token->iat);

            return $token;

        } else {
            throw new SecurityException("Token empty error");
        }

    }

    /**
    * generate randomhash
     */
    function randHash($len = 32)
    {
        return substr(md5(openssl_random_pseudo_bytes(20)), -$len);
    }

}