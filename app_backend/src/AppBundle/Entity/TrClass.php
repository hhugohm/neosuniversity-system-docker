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
 * TrClass
 *
 * @ORM\Table(name="tr_class")
 * @ORM\Entity
 */
class TrClass
{
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
     * @ORM\ManyToOne(targetEntity="TrCourseSection")
     * @ORM\JoinColumn(name="section_id", referencedColumnName="id")
     */
    private $section;

    /**
     * @var string
     *
     * @ORM\Column(name="classDescription", type="string", length=1000, nullable=false)
     */
    private $classdescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="activityType", type="integer", nullable=false)
     */
    private $activitytype;

    /**
     * @var string
     *
     * @ORM\Column(name="videoURL", type="string", length=1000, nullable=true)
     */
    private $videourl;

    /**
     * @var string
     *
     * @ORM\Column(name="pdfURL", type="string", length=1000, nullable=true)
     */
    private $pdfurl;

    /**
     * @var integer
     *
     * @ORM\Column(name="examID", type="integer", nullable=true)
     */
    private $examid;


    /**
     *
     */
    private $files;


    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param mixed $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }

    /**
     * Set $section
     *
     * @param TrCourseSection $section
     * @return TrCourseSection
     */
    public function setSection(TrCourseSection $section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return TrCourseSection
     */
    public function getSection()
    {
        return $this->section;
    }


    /**
     * Set sectionId
     *
     * @param integer $sectionId
     * @return TrClass
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
     * @return TrClass
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
     * Set classdescription
     *
     * @param string $classdescription
     * @return TrClass
     */
    public function setClassdescription($classdescription)
    {
        $this->classdescription = $classdescription;

        return $this;
    }

    /**
     * Get classdescription
     *
     * @return string 
     */
    public function getClassdescription()
    {
        return $this->classdescription;
    }

    /**
     * Set activitytype
     *
     * @param integer $activitytype
     * @return TrClass
     */
    public function setActivitytype($activitytype)
    {
        $this->activitytype = $activitytype;

        return $this;
    }

    /**
     * Get activitytype
     *
     * @return integer 
     */
    public function getActivitytype()
    {
        return $this->activitytype;
    }

    /**
     * Set videourl
     *
     * @param string $videourl
     * @return TrClass
     */
    public function setVideourl($videourl)
    {
        $this->videourl = $videourl;

        return $this;
    }

    /**
     * Get videourl
     *
     * @return string 
     */
    public function getVideourl()
    {
        return $this->videourl;
    }

    /**
     * Set pdfurl
     *
     * @param string $pdfurl
     * @return TrClass
     */
    public function setPdfurl($pdfurl)
    {
        $this->pdfurl = $pdfurl;

        return $this;
    }

    /**
     * Get pdfurl
     *
     * @return string 
     */
    public function getPdfurl()
    {
        return $this->pdfurl;
    }

    /**
     * Set examid
     *
     * @param integer $examid
     * @return TrClass
     */
    public function setExamid($examid)
    {
        $this->examid = $examid;

        return $this;
    }

    /**
     * Get examid
     *
     * @return integer 
     */
    public function getExamid()
    {
        return $this->examid;
    }
}
