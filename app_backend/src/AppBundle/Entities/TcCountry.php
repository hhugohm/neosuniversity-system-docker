<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * TcCountry
 *
 * @ORM\Table(name="tc_country")
 * @ORM\Entity
 */
class TcCountry
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=3, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="countryName", type="string", length=400, nullable=false)
     */
    private $countryname;


    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set countryname
     *
     * @param string $countryname
     * @return TcCountry
     */
    public function setCountryname($countryname)
    {
        $this->countryname = $countryname;

        return $this;
    }

    /**
     * Get countryname
     *
     * @return string 
     */
    public function getCountryname()
    {
        return $this->countryname;
    }
}
