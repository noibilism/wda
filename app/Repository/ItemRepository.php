<?php

namespace App\Repository;

use App\Models\Item;

class ItemRepository
{
//    public const PAGINATOR_COUNT = 10;

    public function all()
    {
        return Item::all();
    }
}
