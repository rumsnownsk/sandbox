<?php

namespace App\Models;

class Category
{
    public array $listAllCategories = array();

    public array $listProductsByCategoryId = array();
    public array $listProductsFromAllCategories = array();


    public string $entity = 'productFolder';
    public string $categoryId = '';

    public function __construct()
    {
        $this->setListAllCategories();
        $this->setListProductsFromAllCategories();

        dump($this->listAllCategories);
        dump($this->listProductsFromAllCategories);
    }

//    protected function getListCategories(): void
//    {
//        if (!empty($this->listAllCategories)){
//            dump('ListCategories already exists');
//            return;
//        };
    public function setListAllCategories(): void
    {
        if ($this->listAllCategories == null){

            $url = "https://api.moysklad.ru/api/remap/1.2/entity/productfolder";
            $categoriesRows = makeApiRequest($url);

            foreach ($categoriesRows['rows'] as $category){
                $this->listAllCategories[$category['id']] = $category;
            }
        }
    }
    protected function setListProductsFromAllCategories(): void
    {
        if ($this->listProductsFromAllCategories == null){
            $listCategories = $this->listAllCategories ? : null;
            foreach ($listCategories as $k => $v){
                $url =  "https://api.moysklad.ru/api/remap/1.2/report/stock/bystore?filter=".
                    "productFolder=https://api.moysklad.ru/api/remap/1.2/entity/productfolder/{$k}";

                $productsByOneCategory = makeApiRequest($url);

                foreach ($productsByOneCategory['rows'] as $product){
                    $productHref = substr($product['meta']['href'], 0, strrpos($product['meta']['href'], '?'));
                    $resArr = explode('/', $productHref);
                    $productId = array_pop($resArr);

                    $this->listProductsFromAllCategories[$productId] = [
                        'hrefStore' => $product['meta']['href'],
                        'nameStock' => $product['stockByStore'][0]['name'],
                        'available' => (int)$product['stockByStore'][0]['stock']
                    ];
                }
            }
        }

    }
    protected function allProductsByCategoryId($categoryId): void
    {
        $url =  "https://api.moysklad.ru/api/remap/1.2/report/stock/bystore?filter=".
                "productFolder=https://api.moysklad.ru/api/remap/1.2/entity/productfolder/{$categoryId}";
        $this->listProductsByCategoryId = makeApiRequest($url);
    }



    public function availableProducts($productId): string|int
    {
        return $this->listProductsFromAllCategories[$productId]['available']?? 'non';
    }


}