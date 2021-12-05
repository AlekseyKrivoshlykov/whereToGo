<?php

namespace App\Repository;

use App\Entity\Place;

interface PlaceRepositoryInterface
{
    /**
     * @return Place
     */
    public function findQuery (string $value): array;

}