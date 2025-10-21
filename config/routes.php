<?php

/** @var Application $app */

use App\Controllers\MainController;

use Rum\Sandbox\Application;


$app->router->get('/', [MainController::class, 'main']);
$app->router->get('/admin', [MainController::class, 'admin']);
$app->router->post('/syncWithDb', [MainController::class, 'syncWithDb'])->withoutCsrfToken();

$app->router->get("/test", function (){
//    if (empty(request()->getData())){
//        echo json_encode([
//            'answer' => 'success',
//            'message' => 'please select product'
//        ]);
//        die;
//    }
//    $idsArray = request()->getData();
//
//    $headers = array(
//        "Authorization:  23e35ff47c415b08527d916104b3359b942c3270",
//        "Accept-Encoding: gzip",
//        "Lognex-Pretty-Print-JSON: true"
//    );
//
//    $ids_str = '';
//    foreach ($idsArray as $k => $v) {
//        $ids_str .= 'id='.$v . ';';
//    }
//
////    $url = read_env('MOYSKLAD_API_URL')."entity/product?filter=$ids_str";
//
//
//
//    $url = 'https://api.moysklad.ru/api/remap/1.2/entity/product?filter=id=0a4a6efb-acfe-11f0-0a80-0692005b7898;id=59683338-ad61-11f0-0a80-06920067ca75;id=ba13118c-ad61-11f0-0a80-1bd30067fd4c;';
//
//    $products = makeApiRequest($url, $headers)['rows'];
//
//    $strValues = '';
////    $insertData = array();
//    for ($i = 0; $i < count($products); $i++) {
//        $strValues .= '(';
//        $strValues .= "'".$products[$i]['id']."',";
//        $strValues .= "'".$products[$i]['name']."',";
//        $strValues .= isset($products[$i]['description']) ? "'".$products[$i]['description']."'," : "'',";
//        $strValues .= isset($products[$i]['category_id']) ? "'" .$products[$i]['category_id']."'," : "'',";
//        $strValues .= isset($products[$i]['code']) ? "'".$products[$i]['code']."'," : "' ',";
//        $strValues .= !empty($products['salePrices'][0]['value']) ? "'".$products['salePrices'][0]['value']."'," : "' 0',";
//        $strValues .= isset($products[$i]['pathName']) ?  "'".$products[$i]['pathName']."'," : "'no-photo',";
//        $strValues .= !empty($products['available']) ? "'".$products['available']."',": "' 0'";
//        $strValues .= ')';
//        if ($i + 1 < count($products)) {
//            $strValues .= ',';
//        }
//    }
//
//    dump($strValues);
//    db()->query("INSERT into moysklad_product (UUID,name,description,category_id, article, price, img_path, available) values {$strValues}");
////    db()->query("INSERT into moysklad_product (UUID,name,description) values ('33','первый товар','dd'),('33344','второй большой товар','dd'),('d4c','третий новый товар','третий новый товар') ");
//
//
//    dd($products);
});
//$app->router->get("/admin/build/create", [\App\Controllers\AdminController::class, 'create']);
//$app->router->post("/admin/build/create", [\App\Controllers\AdminController::class, 'create']);
//$app->router->get("/admin/build/(?P<id>[0-9]+)", [\App\Controllers\AdminController::class, 'build']);
//$app->router->post("/admin/build/(?P<id>[0-9]+)", [\App\Controllers\AdminController::class, 'store']);
//$app->router->get("/admin/build/(?P<id>[0-9]+)/remove", [\App\Controllers\AdminController::class, 'remove']);
//
//$app->router->add('/api/v1/test', function (){
//    response()->json([
//        'status'=> 'success',
//        'message'=>'good page'
//    ]);
//}, ['get', 'post', 'put'])->withoutCsrfToken();
//
//$app->router->get('/api/v1/categories', [App\Controllers\Api\V1\CategoryController::class, 'index']);
//$app->router->get('/api/v1/category/(?P<slug>[a-z0-9-]+)', [App\Controllers\Api\V1\CategoryController::class, 'view']);
//
//
//$app->router->get('/law', [HomeController::class, 'law']);
//$app->router->get('/works', [HomeController::class, 'works']);
//$app->router->get('/service', [HomeController::class, 'service']);
//$app->router->get('/procedure', [HomeController::class, 'procedure']);
//$app->router->get('/ajaxRequest', [HomeController::class, 'ajaxRequest']);
//$app->router->get('/contacts', [HomeController::class, 'contacts']);
//
//$app->router->get('/allWorks', [AjaxController::class, 'allWorks']);
//$app->router->get('/loadMore', [AjaxController::class, 'loadMore']);
//$app->router->get('/worksByCategoryId', [AjaxController::class, 'worksByCategoryId']);
//
//
//$app->router->get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth']);
//
//$app->router->get('/register', [UserController::class, 'register'])->middleware(['guest']);
//$app->router->post('/register', [UserController::class, 'store'])->middleware(['guest']);
//$app->router->get('/login', [UserController::class, 'login'])->middleware(['guest']);
//$app->router->post('/login', [UserController::class, 'auth'])->middleware(['guest']);
//$app->router->get('/signout', [UserController::class, 'signout']);
//
//$app->router->get('/users', [UserController::class, 'index']);
//
//$app->router->get('/work/(?P<id>[0-9]+)?', function (){
////    или $app->router->get('/post/(?P<id>[0-9-]+)/?', function (){
////    (?P) - означает, что это нужно запомнить то, что попадёт внутрь круглых скобок
////    <slug> - просто название переменной
////    [] - какие символы могут находиться в переменной slug
////    [a-z0-9-]  - от a до z, а также любые цифры
////    + означает, что должен быть хоть один символ
////    dump(app()->router->route_params['slug']);
//    return '<p>Some post: </p>'.get_route_param('slug').get_route_param('id');
////    (мультиязычность, часть 1)
//});
//
//$app->router->get('/', [HomeController::class, 'index']);
//
