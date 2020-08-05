<?php

/*
 * This file is part of the NeosUniversity Software.
 *
 * (c) Neossoftware Corporation
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/*
*CategoryController
*/
class CategoryController extends FOSRestController {

  /**
   * @Rest\Get("/api/category")
   */
  public function getAll()
  {
      $categoryService = $this->get('categoryService');

      return $categoryService->getAll();
  }
}