<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * TwControlPanel
 *
 * @ORM\Table(name="tw_control_panel")
 * @ORM\Entity
 */
class TwControlPanel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="course_id", type="integer", nullable=false)
     */
    private $courseId;

    /**
     * @var string
     *
     * @ORM\Column(name="email_id", type="string", length=50, nullable=false)
     */
    private $emailId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enrollment_date", type="date", nullable=false)
     */
    private $enrollmentDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="no_classess_completed", type="integer", nullable=false)
     */
    private $noClassessCompleted;

    /**
     * @var integer
     *
     * @ORM\Column(name="isComplete", type="integer", nullable=false)
     */
    private $iscomplete;


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
     * Set courseId
     *
     * @param integer $courseId
     * @return TwControlPanel
     */
    public function setCourseId($courseId)
    {
        $this->courseId = $courseId;

        return $this;
    }

    /**
     * Get courseId
     *
     * @return integer 
     */
    public function getCourseId()
    {
        return $this->courseId;
    }

    /**
     * Set emailId
     *
     * @param string $emailId
     * @return TwControlPanel
     */
    public function setEmailId($emailId)
    {
        $this->emailId = $emailId;

        return $this;
    }

    /**
     * Get emailId
     *
     * @return string 
     */
    public function getEmailId()
    {
        return $this->emailId;
    }

    /**
     * Set enrollmentDate
     *
     * @param \DateTime $enrollmentDate
     * @return TwControlPanel
     */
    public function setEnrollmentDate($enrollmentDate)
    {
        $this->enrollmentDate = $enrollmentDate;

        return $this;
    }

    /**
     * Get enrollmentDate
     *
     * @return \DateTime 
     */
    public function getEnrollmentDate()
    {
        return $this->enrollmentDate;
    }

    /**
     * Set noClassessCompleted
     *
     * @param integer $noClassessCompleted
     * @return TwControlPanel
     */
    public function setNoClassessCompleted($noClassessCompleted)
    {
        $this->noClassessCompleted = $noClassessCompleted;

        return $this;
    }

    /**
     * Get noClassessCompleted
     *
     * @return integer 
     */
    public function getNoClassessCompleted()
    {
        return $this->noClassessCompleted;
    }

    /**
     * Set iscomplete
     *
     * @param integer $iscomplete
     * @return TwControlPanel
     */
    public function setIscomplete($iscomplete)
    {
        $this->iscomplete = $iscomplete;

        return $this;
    }

    /**
     * Get iscomplete
     *
     * @return integer 
     */
    public function getIscomplete()
    {
        return $this->iscomplete;
    }
}
