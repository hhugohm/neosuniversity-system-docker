<?php

/*
 * This file is part of the NeosUniversity Software.
 *
 * (c) Neossoftware Corporation
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TwUser
 *
 * @ORM\Table(name="tw_user")
 * @ORM\Entity
 */
class TwUser
{

     /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=200, nullable=false)
     * @ORM\Id
     */
    private $email;


    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=50, nullable=false)
     *  
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="completeName", type="string", length=1000, nullable=false)
     */
    private $completename;

   

    /**
     * @var string
     *
     * @ORM\Column(name="pwd", type="string", length=1000, nullable=false)
     */
    private $pwd;


    /**
     * @var string
     *
     * @ORM\Column(name="hash_reset", type="string", length=500, nullable=true)
     */
    private $hashreset;



    /**
     * @var string
     *
     * @ORM\Column(name="country_id", type="string", length=3, nullable=true)
     */
    private $idcountry;


    /**
     * @var string
     *
     * @ORM\Column(name="rol_id", type="integer", nullable=false)
     */
    private $rolid;

    /**
     * @return integer
     */
    public function getRolid()
    {
        return $this->rolid;
    }

    /**
     * @param integer $rolid
     * @return TwUser
     */
    public function setRolid($rolid)
    {
        $this->rolid = $rolid;
        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }



    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }


    /**
     * set hash reset
     */
    public function setHashreset($hashreset) {
        $this->hashreset = $hashreset;
        return $this;
    }

    /**
     * get hash reset
     * @return string  $hashreset
     */
    public function getHashreset() {
        return $this->hashreset;
    }


    /**
     * Set completename
     *
     * @param string $completename
     * @return TwUser
     */
    public function setCompletename($completename)
    {
        $this->completename = $completename;

        return $this;
    }

    /**
     * Get completename
     *
     * @return string
     */
    public function getCompletename()
    {
        return $this->completename;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return TwUser
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set pwd
     *
     * @param string $pwd
     * @return TwUser
     */
    public function setPwd($pwd)
    {
        $this->pwd = $pwd;

        return $this;
    }

    /**
     * Get pwd
     *
     * @return string
     */
    public function getPwd()
    {
        return $this->pwd;
    }

    /**
     * Set idcountry
     *
     * @param string $idcountry
     * @return TwUser
     */
    public function setIdcountry($idcountry)
    {
        $this->idcountry = $idcountry;

        return $this;
    }

    /**
     * Get idcountry
     *
     * @return string
     */
    public function getIdcountry()
    {
        return $this->idcountry;
    }
}
