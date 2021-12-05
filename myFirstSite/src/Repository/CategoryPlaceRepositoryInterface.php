<?php

namespace App\Repository;

use App\Entity\CategoryPlace;

interface CategoryPlaceRepositoryInterface
{
    /**
     * @return CategoryPlace
     */
    public function findCategory ($id);
}