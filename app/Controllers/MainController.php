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
            $products[$i]['pathName'] = $productData[$i]['pathName'] ?? '';
            $products[$i]['description'] = $productData[$i]['description'] ?? '';
            $products[$i]['article'] = $productData[$i]['article'] ?? '';
            $products[$i]['img_path'] = $this->getTinyImageUrl($productData[$i]['images']['meta']['href']);
            $products[$i]['salePrices'] = !empty($productData[$i]['salePrices'][0]['value']) ? $productData[$i]['salePrices'][0]['value'] / 100 : 555;
            $products[$i]['available'] = "?";
        }

        return view('admin', [
            'products' => $products
        ], false);
    }

    protected function getTinyImageUrl($imagesMetaHref): string
    {
        if (!isset($imagesMetaHref)) {
            return '';
        }
        $headers = array(
            "Authorization:  23e35ff47c415b08527d916104b3359b942c3270",
//    "Content-Encoding: application/json",
            "Accept-Encoding: gzip",
            "Lognex-Pretty-Print-JSON: true"
        );

        $imgUrl = makeApiRequest($imagesMetaHref, $headers);

        return $imgUrl['rows'][0]['miniature']['downloadHref'];
    }

    public function syncWithDb(): void
    {
        if (empty(request()->getData())) {
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
            $ids_str .= 'id=' . $v . ';';
        }

        $url = read_env('MOYSKLAD_API_URL') . "entity/product?filter=$ids_str";

        $products = makeApiRequest($url)['rows'];
//        dd($products);

        foreach ($products as $product) {
            $id = $product['id'] ?? null;
            $name = $product['name'] ?? '';
            $article = $product['article'] ?? '';
            $category = $product['pathName'] ?? '';
            $price = !empty($product['salePrices'][0]['value']) ? $product['salePrices'][0]['value'] / 100 : 0;
            $available = 888;
            $imgPath = null;
            $imageUrlApi = null;
            $description = $product['description'] ?? '';

            if (!empty($id)) {

                $imageData = makeApiRequest(read_env('MOYSKLAD_API_URL') . "entity/product/{$id}/images");

                if (!empty($imageData['rows'][0]['meta']['downloadHref'])) {
                    $imageUrlApi = $imageData['rows'][0]['meta']['downloadHref'];

                    $imagePath = read_env('IMAGES_PATH') . "{$id}";
                    $existingFiles = glob($imagePath . '.*');
                    foreach ($existingFiles as $file) {
                        if (file_exists($file)) {
                            @unlink($file);
                        }
                    }

                    $headers = array(
                        "Authorization: 23e35ff47c415b08527d916104b3359b942c3270",
                        "Accept-Encoding: gzip",
                        "Accept: application/json;charset=utf-8"
                    );

                    $imgPath = downloadImage($imageUrlApi, $imagePath, $headers, $id);
                }
            }

            db()->query("
                INSERT INTO moysklad_product
                    (UUID, name, description, article, price, category, img_path, image_url_api, available)
                VALUES
                    (:UUID, :name, :description, :article, :price, :category, :img_path, :image_url_api, :available)",
                [
                    'UUID' => $id,
                    'name' => $name,
                    'description' => $description,
                    'article' => $article,
                    'price' => $price,
                    'category' => $category,
                    'image_url_api' => $imageUrlApi,
                    'img_path' => $imgPath,
                    'available' => $available
                ]
            );
        }
        if (true) {
            echo json_encode([
                'answer' => 'success',
                'redirect' => '/',
                'message' => 'all complete'
            ]);
        }
        die;
    }

    protected function checkProductInDbById($id): bool|array|string
    {
        $data = db()->query('SELECT * FROM `moysklad_product` WHERE UUID = ? LIMIT 1', [$id])->get();
        return empty($data);
    }

//    public function test()
//    {
////    dd($ids_str);
//
//        dd(__METHOD__);
//
//        $url = 'https://api.moysklad.ru/api/remap/1.2/entity/product?filter=id=0a4a6efb-acfe-11f0-0a80-0692005b7898;id=2cd81388-af23-11f0-0a80-194f00087cdc;id=3dea83fb-af20-11f0-0a80-082f0007dcfa;';
////        $url = 'https://api.moysklad.ru/api/remap/1.2/entity/product?filter=id=0a4a6efb-acfe-11f0-0a80-0692005b7898;id=2cd81388-af23-11f0-0a80-194f00087cdc;id=3dea83fb-af20-11f0-0a80-082f0007dcfa;';
//
//        $products = makeApiRequest($url)['rows'];
//
//        foreach ($products as $product) {
//            $id = $product['id'] ?? null;
//            $name = $product['name'] ?? '';
//            $article = $product['article'] ?? '';
//            $category = $product['pathName'] ?? '';
//            $price = !empty($product['salePrices'][0]['value']) ? $product['salePrices'][0]['value'] / 100 : 0;
//            $available = 888;
//            $imgPath = null;
//            $description = $product['description'] ?? '';
//
////            dump($product['id']);
//            if (!empty($id)) {
//
//                $imageData = makeApiRequest(read_env('MOYSKLAD_API_URL') . "entity/product/{$id}/images");
//
//                if (!empty($imageData['rows'][0]['meta']['downloadHref'])) {
//                    $imgUrl = $imageData['rows'][0]['meta']['downloadHref'];
//
//                    $imagePath = read_env('IMAGES_PATH') . "{$id}";
//                    $existingFiles = glob($imagePath . '.*');
//                    foreach ($existingFiles as $file) {
//                        if (file_exists($file)) {
//                            @unlink($file);
//                        }
//                    }
//
//                    $headers = array(
//                        "Authorization: 23e35ff47c415b08527d916104b3359b942c3270",
//                        "Accept-Encoding: gzip",
//                        "Accept: application/json;charset=utf-8"
//                    );
//
//                    $imgPath = downloadImage($imgUrl, $imagePath, $headers, $id);
//
////                    dump($imgPath);
//                }
//            }
//
//            db()->query("
//                INSERT INTO moysklad_product
//                    (UUID, name, description, article, price, category, img_path, image_url_api, available)
//                VALUES
//                    (:UUID, :name, :description, :article, :price, :category, :img_path, :image_url_api, :available)",
//                [
//                    'UUID' => $id,
//                    'name' => $name,
//                    'description' => $description,
//                    'article' => $article,
//                    'price' => $price,
//                    'category' => $category,
//                    'image_url_api' => $imgPath,
//                    'img_path' => $imgPath,
//                    'available' => $available
//                ]
//            );
//        }
//
////        for ($i = 0; $i < count($products); $i++) {
////            $strValues .= '(';
////            $strValues .= "'" . $products[$i]['id'] . "',";
////            $strValues .= "'" . $products[$i]['name'] . "',";
////            $strValues .= isset($products[$i]['description']) ? "'" . $products[$i]['description'] . "'," : "'',";
////            $strValues .= isset($products[$i]['article']) ? "'" . $products[$i]['code'] . "'," : "' ',";
////            $strValues .= !empty($products['salePrices'][0]['value']) ? "'" . $products['salePrices'][0]['value'] . "'," : "' 0',";
////            $strValues .= isset($products[$i]['pathName']) ? "'" . $products[$i]['pathName'] . "'," : "'no-photo',";
////            $strValues .= !empty($products['available']) ? "'" . $products['available'] . "'," : "' 0'";
////            $strValues .= ')';
////            if ($i + 1 < count($products)) {
////                $strValues .= ',';
////            }
////            dd($strValues);
////
////        }
//
//    }

}