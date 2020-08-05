<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * TcCourse
 *
 * @ORM\Table(name="tc_course")
 * @ORM\Entity
 */
class TcCourse
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
     * @ORM\Column(name="courseName", type="string", length=200, nullable=false)
     */
    private $coursename;

    /**
     * @var integer
     *
     * @ORM\Column(name="category_id", type="integer", nullable=false)
     */
    private $categoryId;

    /**
     * @var integer
     *
     * @ORM\Column(name="author_id", type="integer", nullable=false)
     */
    private $authorId;

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
     * @ORM\Column(name="courseDesc", type="string", length=20000, nullable=false)
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     * @return TcCourse
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set authorId
     *
     * @param integer $authorId
     * @return TcCourse
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;

        return $this;
    }

    /**
     * Get authorId
     *
     * @return integer 
     */
    public function getAuthorId()
    {
        return $this->authorId;
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
