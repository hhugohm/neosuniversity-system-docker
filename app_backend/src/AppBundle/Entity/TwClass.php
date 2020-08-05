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
 * TwClass
 *
 * @ORM\Table(name="tw_class")
 * @ORM\Entity
 */
class TwClass
{
    /**
     * @var integer
     *
     * @ORM\Column(name="control_panel_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $controlPanelId;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="section_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $sectionId;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="class_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $classId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="isCompleted", type="integer", nullable=false)
     */
    private $iscompleted;


    /**
     * ORM\ManyToOne(targetEntity="TrClass")
     * ORM\JoinColumn(name="section_id", referencedColumnName="section_id")
     * ORM\JoinColumn(name="class_id", referencedColumnName="class_id")
     */
    private $clase;

    /**
     * ORM\ManyToOne(targetEntity="TwSection", inversedBy="twClasses")
     * ORM\JoinColumn(name="control_panel_id", referencedColumnName="control_panel_id")
     * ORM\JoinColumn(name="section_id", referencedColumnName="section_id")
     */
    private $twSection;

    public function setTwSection($twSection) {
        $this->twSection = $twSection;
        return $this;
    }

    public function getTwSection() {
        return $this->twSection;
    }


    /**
     * Set $clase
     *
     * @param TrClass $clase
     * @return TwClass
     */
    public function setClase(TrClass $clase)
    {
        $this->clase = $clase;

        return $this;
    }

    /**
     * Get section
     *
     * @return TrClass
     */
    public function getClase()
    {
        return $this->clase;
    }
    
    
    /**
     * Set controlPanelId
     *
     * @param integer $controlPanelId
     * @return TwClass
     */
    public function setControlPanelId($controlPanelId)
    {
        $this->controlPanelId = $controlPanelId;
        
        return $this;
    }
    
    /**
     * Get controlPanelId
     *
     * @return integer 
     */
    public function getControlPanelId()
    {
        return $this->controlPanelId;
    }
    
    /**
     * Set sectionId
     *
     * @param integer $sectionId
     * @return TwClass
     */
    public function setSectionId($sectionId)
    {
        $this->sectionId = $sectionId;
        
        return $this;
    }
    
    /**
     * Get sectionId
     *
     * @return integer 
     */
    public function getSectionId()
    {
        return $this->sectionId;
    }
    
    /**
     * Set classId
     *
     * @param integer $classId
     * @return TwClass
     */
    public function setClassId($classId)
    {
        $this->classId = $classId;
        
        return $this;
    }
    
    /**
     * Get classId
     *
     * @return integer 
     */
    public function getClassId()
    {
        return $this->classId;
    }
    
    /**
     * Set iscompleted
     *
     * @param string $iscompleted
     * @return TwClass
     */
    public function setIscompleted($iscompleted)
    {
        $this->iscompleted = $iscompleted;
        
        return $this;
    }
    
    /**
     * Get iscompleted
     *
     * @return string 
     */
    public function getIscompleted()
    {
        return $this->iscompleted;
    }
}