<?php

namespace App\Controllers;

class MainController
{
    public function main()
    {
        $products = db()->query('SELECT * FROM `moysklad_product` order by id desc limit 10')->get();

        return view('main', ['products' => $products], false);
    }

    public function admin()
    {
        $headers = array(
            "Authorization:  23e35ff47c415b08527d916104b3359b942c3270",
//    "Content-Encoding: application/json",
            "Accept-Encoding: gzip",
            "Lognex-Pretty-Print-JSON: true"
        );
        $url = "https://api.moysklad.ru/api/remap/1.2/entity/product";
        $productData = makeApiRequest($url, $headers)['rows'];

        $products = [];

        for ($i = 0; $i < count($productData); $i++) {
            $products[$i]['id'] = $productData[$i]['id'];
            $products[$i]['name'] = $productData[$i]['name'] ?? '';
            $products[$i]['category_id'] = $productData[$i]['category_id'] ?? '';
            $products[$i]['description'] = $productData[$i]['description'] ?? '';
            $products[$i]['article'] = $productData[$i]['code'] ?? '';
//            $products[$i]['img_path'] = empty($productData[$i]['pathName']) ? 'no photo' : $productData[$i]['pathName'] ;
            $products[$i]['img_path'] = "https://miniature-prod.moysklad.ru/miniature/6f9f2730-acfa-11f0-0a80-1c4f0003e079/documentminiature/3626a278-199c-4d73-bfd9-ac9d65975017";
            $products[$i]['price'] = !empty($productData['salePrices'][0]['value']) ? $productData['salePrices'][0]['value'] / 100 : 0;
            $products[$i]['available'] = 5;
        }


        return view('admin', [
            'products' => $products
        ], false);

    }

    public function syncWithDb(): void
    {
//        if (empty(request()->getData())){
//            echo json_encode([
//                'answer' => 'success',
//                'message' => 'please select product'
//            ]);
//            die;
//        }
//        $idsArray = request()->getData();
//
//        $headers = array(
//            "Authorization:  23e35ff47c415b08527d916104b3359b942c3270",
//            "Accept-Encoding: gzip",
//            "Lognex-Pretty-Print-JSON: true"
//        );
//
//        $ids_str = '';
//        foreach ($idsArray as $k => $v) {
//            $ids_str .= 'id='.$v . ';';
//        }
//
//        $url = read_env('MOYSKLAD_API_URL')."entity/product?filter=$ids_str";
////        dd($url);
//        $products = makeApiRequest($url, $headers);
        if (empty(request()->getData())){
            echo json_encode([
                'answer' => 'success',
                'message' => 'please select product'
            ]);
            die;
        }
        $idsArray = request()->getData();

        $headers = array(
            "Authorization:  23e35ff47c415b08527d916104b3359b942c3270",
            "Accept-Encoding: gzip",
            "Lognex-Pretty-Print-JSON: true"
        );

        $ids_str = '';
        foreach ($idsArray as $k => $v) {
            $ids_str .= 'id='.$v . ';';
        }

    $url = read_env('MOYSKLAD_API_URL')."entity/product?filter=$ids_str";

        $products = makeApiRequest($url, $headers)['rows'];

        $strValues = '';
        for ($i = 0; $i < count($products); $i++) {
            $strValues .= '(';
            $strValues .= "'".$products[$i]['id']."',";
            $strValues .= "'".$products[$i]['name']."',";
            $strValues .= isset($products[$i]['description']) ? "'".$products[$i]['description']."'," : "'',";
            $strValues .= isset($products[$i]['category_id']) ? "'" .$products[$i]['category_id']."'," : "'',";
            $strValues .= isset($products[$i]['code']) ? "'".$products[$i]['code']."'," : "' ',";
            $strValues .= !empty($products['salePrices'][0]['value']) ? "'".$products['salePrices'][0]['value']."'," : "' 0',";
            $strValues .= isset($products[$i]['pathName']) ?  "'".$products[$i]['pathName']."'," : "'no-photo',";
            $strValues .= !empty($products['available']) ? "'".$products['available']."',": "' 0'";
            $strValues .= ')';
            if ($i + 1 < count($products)) {
                $strValues .= ',';
            }
        }

        db()->query("INSERT into moysklad_product (UUID,name,description,category_id, article, price, img_path, available) values {$strValues}");

        die;
//        response()->redirect('/admin');
    }

}