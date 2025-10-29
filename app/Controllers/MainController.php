<?php

namespace App\Controllers;

use App\Models\Category;

class MainController
{
    public function main()
    {
        $products = db()->query('SELECT ms.*, c.name as category_name
                                    FROM moysklad_product as ms
                                    INNER JOIN categories as c
                                    ON ms.category_id = c.id')->get();

        return view('main', ['products' => $products]);
    }
}