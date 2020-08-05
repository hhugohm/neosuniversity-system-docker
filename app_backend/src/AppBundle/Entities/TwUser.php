<?php



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
     * @ORM\Column(name="username", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * @ORM\Column(name="email", type="string", length=200, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="pwd", type="string", length=1000, nullable=false)
     */
    private $pwd;

    /**
     * @var string
     *
     * @ORM\Column(name="idCountry", type="string", length=3, nullable=true)
     */
    private $idcountry;


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
