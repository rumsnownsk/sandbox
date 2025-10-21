<?php

namespace Rum\Sandbox;

class Application
{
    protected string $uri;

    public Request $request;
    public Response $response;
    public Router $router;
    public View $view;
    public DataBase $db;

    public static Application $app;

    public function __construct()
    {
        self::$app = $this;

        $this->uri = $_SERVER['REQUEST_URI'];

        $this->request = new Request($this->uri);
        $this->response = new Response();

        $this->router = new Router($this->request, $this->response);
        $this->view = new View();

        $this->db = new DataBase();

//        dd(read_env('DB_HOST'));
//        $this->generatedCsrfToken();
    }

    public function run(): void // void - ничего не возвращаем
    {
        echo $this->router->dispatch();
    }

    public function generatedCsrfToken(): void
    {
//        if (!\CoreApp\session()->has('csrf_token')){
//            \CoreApp\session()->set('csrf_token', md5(uniqid(mt_rand(), true)));
//        }
    }
}