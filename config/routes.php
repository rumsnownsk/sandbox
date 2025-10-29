<?php

/** @var Application $app */

use App\Controllers\MainController;
use App\Controllers\AdminController;

use Rum\Sandbox\Application;


$app->router->get('/', [MainController::class, 'main']);
$app->router->get('/admin', [AdminController::class, 'index']);
$app->router->get('/admin/sync', [MainController::class, 'sync']);

$app->router->post('/syncWithDb', [AdminController::class, 'syncWithDb'])->withoutCsrfToken();

$app->router->get("/test", [MainController::class, 'test'])->withoutCsrfToken();
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
