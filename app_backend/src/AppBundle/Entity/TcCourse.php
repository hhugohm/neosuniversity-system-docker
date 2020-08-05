<?php

/*
*
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
 * TcCourse
 *
 * @author Mario Hidalgo aka neossoftware
 *
 * @ORM\Table(name="tc_course")
 * @ORM\Entity
 */
class TcCourse
{
    /**
     * @var integer
     *
     * @ORM\Column( type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="courseName", type="string", length=200, nullable=false)
     */
    private $coursename;


    /**
     * var author
     *
     *
     * Unidirectional - Many-To-One
     *
     * @ORM\ManyToOne(targetEntity="TcAuthor")
     *
     */
    private $author;


    /**
     *
     * Many courses have many categories
     *
     * @ORM\ManyToMany(targetEntity="TcCategory", inversedBy="courses")
     * @ORM\JoinTable(name="tr_categ_course",
     *  joinColumns={@ORM\JoinColumn(name="course_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     */
    private $categories;

    /**
     *
     * Many courses have many objectives
     *
     * @ORM\ManyToMany(targetEntity="TcObjective")
     * @ORM\JoinTable(name="tr_objective_course",
     *  joinColumns={@ORM\JoinColumn(name="course_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="objective_id", referencedColumnName="id")}
     * )
     */
    private $objectives;

    /**
     *
     * Many courses have many requirements (student skills)
     *
     * @ORM\ManyToMany(targetEntity="TcRequirement")
     * @ORM\JoinTable(name="tr_requirement_course",
     *  joinColumns={@ORM\JoinColumn(name="course_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="requirement_id", referencedColumnName="id")}
     * )
     */
    private $requirements;

    /**
     * @var integer
     *
     * @ORM\Column(name="numbClasses", type="integer", nullable=true)
     */
    private $numbclasses;

    /**
     * @var string
     *
     * @ORM\Column(name="numHrsVideo", type="decimal", precision=4, scale=1, nullable=true)
     */
    private $numhrsvideo;

    /**
     * @var string
     *
     * @ORM\Column(name="courseDesc", type="text",  nullable=false)
     */
    private $coursedesc;

    /**
     * @var integer
     *
     * @ORM\Column(name="isFree", type="integer", nullable=false)
     */
    private $isfree;

    /**
     * @var string
     *
     * @ORM\Column(name="cost", type="decimal", precision=5, scale=1, nullable=false)
     */
    private $cost;

    /**
     * @var string
     *
     * @ORM\Column(name="imgThumb", type="string", length=500, nullable=false)
     */
    private $imgthumb;

    /**
     * @var string
     *
     * @ORM\Column(name="shortdesc", type="string", length=500, nullable=false)
     */
    private $shortdesc;

    /**
     * @var string
     *
     * @ORM\Column(name="imgcourse", type="string", length=250, nullable=false)
     */
    private $imgcourse;

    /**
     * @var
     * @ORM\Column(name="author_id", type="integer",  nullable=false)
     *
     */
    private $authorId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="date", nullable=false)
     */
    private $creationdate;

    /**
     * @var
     * @ORM\Column(name="isOnline", type="integer",  nullable=false)
     *
     */
    private $isOnline;

    /**
     * @var
     * @ORM\Column(name="urlCourseOnline", type="string", length=1000,  nullable=true)
     *
     */
    private $urlCourseOnline;

    /**
     * @return mixed
     */
    public function getUrlCourseOnline()
    {
        return $this->urlCourseOnline;
    }

    /**
     * @param mixed $urlCourseOnline
     */
    public function setUrlCourseOnline($urlCourseOnline)
    {
        $this->urlCourseOnline = $urlCourseOnline;
    }

    /**
     * @return mixed
     */
    public function getIsOnline()
    {
        return $this->isOnline;
    }

    /**
     * @param mixed $isOnline
     */
    public function setIsOnline($isOnline)
    {
        $this->isOnline = $isOnline;
    }

    /**
     * @return \DateTime
     */
    public function getCreationdate()
    {
        return $this->creationdate;
    }

    /**
     * @param \DateTime $creationdate
     * @return TcCourse
     */
    public function setCreationdate($creationdate)
    {
        $this->creationdate = $creationdate;

        return $this;
    }



    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * @param mixed $authorId
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;
    }



    /**
     * @return string
     */
    public function getShortdesc()
    {
        return $this->shortdesc;
    }

    /**
     * @param string $shortdesc
     * @return TcCourse
     */
    public function setShortdesc($shortdesc)
    {
        $this->shortdesc = $shortdesc;

        return $this;
    }

    /**
     * @return string
     */
    public function getImgcourse()
    {
        return $this->imgcourse;
    }

    /**
     * @param string $imgcourse
     * @return TcCourse
     */
    public function setImgcourse($imgcourse)
    {
        $this->imgcourse = $imgcourse;

        return $this;
    }

    /**
     * @return string
     */
    public function getImgthumb()
    {
        return $this->imgthumb;
    }

    /**
     * @param string $imgthumb
     * @return TcCourse
     */
    public function setImgthumb($imgthumb)
    {
        $this->imgthumb = $imgthumb;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set coursename
     *
     * @param string $coursename
     * @return TcCourse
     */
    public function setCoursename($coursename)
    {
        $this->coursename = $coursename;

        return $this;
    }

    /**
     * Get coursename
     *
     * @return string
     */
    public function getCoursename()
    {
        return $this->coursename;
    }

    
    public function getCategories()
    {

        return $this->categories;
    }

    
    public function setCategories(ArrayCollection $categories)
    {
        $this->categories = $categories;
    }

    /*
    *get $objectives
    *@return ArrayCollection objectives
    */
    public function getObjectives()
    {

        return $this->objectives;
    }

    /*
    *set $objectives
    */
    public function setObjectives(ArrayCollection $objectives)
    {
        $this->objectives = $objectives;
    }

     /*
    *get $requirements
    *@return ArrayCollection requirements
    */
    public function getRequirements()
    {

        return $this->requirements;
    }

    /*
    *set $requirements
    */
    public function setRequirements(ArrayCollection $requirements)
    {
        $this->requirements = $requirements;
    }           

    /**
     * Set $author
     *
     * @param TcAuthor $author
     * @return TcCourse
     */
    public function setAuthor(TcAuthor $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return TcAuthor
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set numbclasses
     *
     * @param integer $numbclasses
     * @return TcCourse
     */
    public function setNumbclasses($numbclasses)
    {
        $this->numbclasses = $numbclasses;

        return $this;
    }

    /**
     * Get numbclasses
     *
     * @return integer
     */
    public function getNumbclasses()
    {
        return $this->numbclasses;
    }

    /**
     * Set numhrsvideo
     *
     * @param string $numhrsvideo
     * @return TcCourse
     */
    public function setNumhrsvideo($numhrsvideo)
    {
        $this->numhrsvideo = $numhrsvideo;

        return $this;
    }

    /**
     * Get numhrsvideo
     *
     * @return string
     */
    public function getNumhrsvideo()
    {
        return $this->numhrsvideo;
    }

    /**
     * Set coursedesc
     *
     * @param string $coursedesc
     * @return TcCourse
     */
    public function setCoursedesc($coursedesc)
    {
        $this->coursedesc = $coursedesc;

        return $this;
    }

    /**
     * Get coursedesc
     *
     * @return string
     */
    public function getCoursedesc()
    {
        return $this->coursedesc;
    }

    /**
     * Set isfree
     *
     * @param integer $isfree
     * @return TcCourse
     */
    public function setIsfree($isfree)
    {
        $this->isfree = $isfree;

        return $this;
    }

    /**
     * Get isfree
     *
     * @return integer
     */
    public function getIsfree()
    {
        return $this->isfree;
    }

    /**
     * Set cost
     *
     * @param string $cost
     * @return TcCourse
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return string
     */
    public function getCost()
    {
        return $this->cost;
    }
}
