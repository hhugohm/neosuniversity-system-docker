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
 * TcObjective mapping
 *
 * @ORM\Table(name="tc_objective")
 * @ORM\Entity
 */
class TcObjective
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="objectiveName", type="string", length=1000, nullable=false)
     */

    private $objectiveName;




    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set categoryname
     *
     * @param string $categoryname
     * @return TcCategory
     */
    public function setObjectiveName($objectiveName)
    {
        $this->objectiveName = $objectiveName;

        return $this;
    }

    /**
     * Get categoryname
     *
     * @return string
     */
    public function getObjectiveName()
    {
        return $this->objectiveName;
    }
}