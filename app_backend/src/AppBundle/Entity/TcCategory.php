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
 * TcCategory
 *
 * @ORM\Table(name="tc_category")
 * @ORM\Entity
 */
class TcCategory
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
     * @ORM\Column(name="categoryName", type="string", length=100, nullable=false)
     */

    private $categoryname;

    /**
     *
     * Many categories have many courses
     *
     * @ORM\ManyToMany(targetEntity="TcCourse", inversedBy="categories")
     * @ORM\JoinTable(name="tr_categ_course",
     *  joinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="course_id", referencedColumnName="id")}
     * )
     */
     private $courses;

     public function getCourses() {

        return $this->courses;
     }


     public function setCourses(ArrayCollection $courses) {
        $this->courses = $courses;
     }



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
    public function setCategoryname($categoryname)
    {
        $this->categoryname = $categoryname;

        return $this;
    }

    /**
     * Get categoryname
     *
     * @return string
     */
    public function getCategoryname()
    {
        return $this->categoryname;
    }
}
