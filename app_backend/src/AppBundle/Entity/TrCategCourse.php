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
 * TrCategCourse
 *
 * @ORM\Table(name="tr_categ_course", indexes={@ORM\Index(name="idCourse", columns={"idCourse"})})
 * @ORM\Entity
 */
class TrCategCourse
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idCategory", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idcategory;

    /**
     * @var integer
     *
     * @ORM\Column(name="idCourse", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idcourse;


    /**
     * Set idcategory
     *
     * @param integer $idcategory
     * @return TrCategCourse
     */
    public function setIdcategory($idcategory)
    {
        $this->idcategory = $idcategory;

        return $this;
    }

    /**
     * Get idcategory
     *
     * @return integer
     */
    public function getIdcategory()
    {
        return $this->idcategory;
    }

    /**
     * Set idcourse
     *
     * @param integer $idcourse
     * @return TrCategCourse
     */
    public function setIdcourse($idcourse)
    {
        $this->idcourse = $idcourse;

        return $this;
    }

    /**
     * Get idcourse
     *
     * @return integer
     */
    public function getIdcourse()
    {
        return $this->idcourse;
    }
}
