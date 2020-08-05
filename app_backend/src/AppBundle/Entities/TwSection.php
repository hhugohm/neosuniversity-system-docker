<?php



use Doctrine\ORM\Mapping as ORM;

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
