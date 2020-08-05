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
     * @ORM\Column(name="idCountry", type="string", length=3, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcountry;

    /**
     * @var string
     *
     * @ORM\Column(name="countryName", type="string", length=400, nullable=false)
     */
    private $countryname;


    /**
     * Get idcountry
     *
     * @return string
     */
    public function getIdcountry()
    {
        return $this->idcountry;
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
