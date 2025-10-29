<?php

namespace App\Controllers;

use App\Models\Category;

class MainController
{
    public function main()
    {
        $products = db()->query('SELECT * FROM `moysklad_product` order by id desc limit 10')->get();

        return view('main', ['products' => $products]);
    }



}
