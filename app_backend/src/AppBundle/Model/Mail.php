<?php

/*
 * This file is part of the NeosUniversity Software.
 *
 * (c) Neossoftware Corporation
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Model;

/**
 * Clase modelo que tiene las propiedad para poder enviar un correo electronico
 * @author Mario Hidalgo
 */
class Mail
{

    private $mailTo;

    private $message;

    private $nameTo;

    private $subject;

    /**
     * set Mail
     */
    function setMailTo($mailTo)
    {
        $this->mailTo = $mailTo;
        return $this;
    }

    /**
     *getMailTo
     */
    function getMailTo()
    {
        return $this->mailTo;
    }

    /**
    * setMessage
     */
    function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
     /**
      * getMessage
      */
    function getMessage()
    {
       return $this->message;

    }

    /**
     * setNameTo
     */
    function setNameTo($nameTo) {
        $this ->nameTo = $nameTo;
        return $this;
    }

    /**
     * getNameTo
    */
    function getNameTo() {
       return $this->nameTo;
    }

    /**
    *
     * Set Subject*/
    function setSubject($subject) {
        $this->subject = $subject;
        return $this;
    }

    /*
     * getSubject
     * */
    function getSubject() {
        return $this->subject;
    }




}