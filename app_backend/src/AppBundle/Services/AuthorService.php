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
use AppBundle\Entity\TcAuthor;

class AuthorService {
    /***
     *entityManager es el objeto para poder tener acceso a la BD por medio de ORM
     */
    private $entityManager = null;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /***
     *Get All courses from DB
     */
    public function getAll() {
        $authors = $this->entityManager->getRepository('AppBundle:TcAuthor')->findAll();
        return $authors;
    }

}