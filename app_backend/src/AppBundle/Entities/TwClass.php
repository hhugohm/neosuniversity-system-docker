<?php



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
     * @ORM\Column(name="isCompleted", type="string", length=45, nullable=false)
     */
    private $iscompleted;


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
