<?php

/*
 * This file is part of the NeosUniversity Software.
 *
 * (c) Neossoftware Corporation
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\TcCategory;

class CategoryService {
    /***
     *entityManager es el objeto para poder tener acceso a la BD por medio de ORM
     */
    private $entityManager = null;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /***
     *Get All categories from DB
     */
    public function getAll() {
        $categories = $this->entityManager->getRepository('AppBundle:TcCategory')->findAll();
        return $categories;
    }

}