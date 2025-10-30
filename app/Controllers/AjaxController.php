<?php

namespace App\Controllers;

use App\Models\Category;

class AjaxController extends BaseController
{
    public function getcategories(): void
    {
        $wh_id = request()->post('wh_id');
        $categoryId = request()->post('ctg_id');

        if ($wh_id && $categoryId != 0) {
            $filter = 'store=https://api.moysklad.ru/api/remap/1.2/entity/store/' . $wh_id .
                ';productFolder=https://api.moysklad.ru/api/remap/1.2/entity/productfolder/' . $categoryId;
        } elseif ($wh_id && $categoryId == 0) {
            $filter = 'store=https://api.moysklad.ru/api/remap/1.2/entity/store/' . $wh_id .';';
        }
        $url = "https://api.moysklad.ru/api/remap/1.2/report/stock/bystore?filter=" . urlencode($filter);


//        dump(makeApiRequest(url: $url));
        $rowsProductsFilter = makeApiRequest(url: $url)['rows'];
//        dump($rowsProductsFilter);
        $ids_str = '';

        $arrayCountProducts = [];

        foreach ($rowsProductsFilter as $int => $item) {
            $id = explodeHref($item['meta']['href']);
            $arrayCountProducts[$id]['available'] = $item['stockByStore'][0]['stock'];
            $ids_str .= "id=" . $id . ";";
        }
        $productsByIds = makeApiRequest("https://api.moysklad.ru/api/remap/1.2/entity/product?filter=$ids_str")['rows'];

        $products = [];

        for ($i = 0; $i < count($productsByIds); $i++) {
            $products[] = [
                'id' => $productsByIds[$i]['id'],
                'name' => $productsByIds[$i]['name'],
                'description' => $productsByIds[$i]['description'],
                'category' => $productsByIds[$i]['pathName'],
                'article' => $productsByIds[$i]['article'],
                'image_path' => $this->getTinyImageUrl($productsByIds[$i]['images']['meta']['href']),
                'price' => !empty($productsByIds[$i]['salePrices'][0]['value']) ? $productsByIds[$i]['salePrices'][0]['value'] / 100 : 000,
                'available' => $arrayCountProducts[$productsByIds[$i]['id']]['available']
            ];
        }

        echo json_encode([
            'answer' => 'success',
            'tbody_products' => view()->renderPartial("incs/tbody_products",
                [
                    'products' => $products
                ])
        ]);
    }


}
