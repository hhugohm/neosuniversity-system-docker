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
use Doctrine\Common\Collections\ArrayCollection;

/**
 * TwSection
 *
 * @ORM\Table(name="tw_section")
 * @ORM\Entity
 */
class TwSection
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
     * @ORM\Column(name="classesCompleted", type="integer", nullable=false)
     */
    private $classescompleted;


    /**
     * @ORM\ManyToOne(targetEntity="TrCourseSection")
     * @ORM\JoinColumn(name="section_id", referencedColumnName="id")
     */
    private $section;


    /**
     *
     * ORM\OneToMany(targetEntity="TwClass", mappedBy="twSection")
     * ORM\JoinColumn(name="control_panel_id", referencedColumnName="control_panel_id")
     * ORM\JoinColumn(name="section_id", referencedColumnName="section_id")
     */
    protected $twClasses;


    /**
     * get classes
     *
     * @return classes
     */
    public function getClasses()
    {
        return $this->twClasses;
    }

    /**
     *  set classes an array collection
     */
    public function setTwClasses($twClasses)
    {
        $this->twClasses = $twClasses;
    }

    /**
     * @param  $section TrCourseSection
     */
    public function setSection($section) {
        $this->section = $section;
        return $this;
    }

    /**
    * @return  TrCourseSection
     */
    public function getSection() {
        return $this->section;
    }


        /**
     * Set controlPanelId
     *
     * @param integer $controlPanelId
     * @return TwSection
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
     * @return TwSection
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
     * Set classescompleted
     *
     * @param integer $classescompleted
     * @return TwSection
     */
    public function setClassescompleted($classescompleted)
    {
        $this->classescompleted = $classescompleted;
        
        return $this;
    }
    
    /**
     * Get classescompleted
     *
     * @return integer 
     */
    public function getClassescompleted()
    {
        return $this->classescompleted;
    }
}