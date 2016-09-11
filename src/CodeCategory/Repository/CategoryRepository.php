<?php

namespace CodePress\CodeCategory\Repository;

use CodePress\CodeDatabase\AbstractRepository;
use CodePress\CodeCategory\Models\Category;

class CategoryRepository extends AbstractRepository
{
    public function model()
    {
        return Category::class;
    }
}