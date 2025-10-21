<?php
namespace Rum\Sandbox;

class Router
{
    protected array $routes = [];
    protected array $route_params = [];

    public function __construct(
        protected Request $request,
        protected Response $response
    )
    {
    }

    /**
     * @param $path
     * @param $callback
     * @param $method
     * @return Router
     */
    public function add($path, $callback, $method): self
    {
        $path = trim($path, '/');
        if (is_array($method)){
            $method = array_map("strtoupper", $method);
        } else {
            $method = [strtoupper($method)];
        }
        $this->routes[] = [
            'path' => "/$path",
            'callback' => $callback,
            'middleware' => [],
            'method' => $method,
            'needCsrfToken' => true
        ];
        return $this;
    }

    public function get($path, $callback):self
    {
        return $this->add($path, $callback, 'GET');
    }

    public function post($path, $callback):self
    {
        return $this->add($path, $callback, 'POST');
    }

    public function put($path, $callback):self
    {
        return $this->add($path, $callback, 'PUT');
    }

    public function dispatch(): mixed
    {
        $path = $this->request->getPath();
        $route = $this->matchRoute($path);

        if (false === $route) {
            abort('400004 - Page not found', 404);
        }

        if (is_array($route['callback'])) {
            $route['callback'][0] = new $route['callback'][0];
        }

        return call_user_func($route['callback']);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function getRouteParams(): array
    {
        return $this->route_params;
    }

    protected function matchRoute($path): mixed
    {
        $allowed_methods = [];
        foreach ($this->routes as $route) {
            if (preg_match("#^{$route['path']}$#", "/{$path}", $matches)) {

                if (!in_array($this->request->getMethod(), $route['method'])){
                    $allowed_methods = array_merge($allowed_methods, $route['method']);
                    continue;
                }

                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $this->route_params[$k] = $v;
                    }
                }

                if (request()->isPost()){
                    if ($route['needCsrfToken'] && !$this->checkCsrfToken()) {
                        if (request()->isAjax()) {
                            echo json_encode([
                                'status' => 'error',
                                'data' => 'security error (need csrf-token)'
                            ]);
                            die;
                        } else {
                            print_r('Method Not Allowedqqqqq');

                            abort('Page expired', 419);
                        }
                    }
                }

                if ($route['middleware']){
                    foreach ($route['middleware'] as $item) {
                        $middleware =  MIDDLEWARE[$item] ?? false;
                        if ($middleware){
                            (new $middleware)->handle();
                        }

                    }
                }
                return $route;
            }
        }

        if ($allowed_methods){
            header("Allow: ".implode(', ', array_unique($allowed_methods)));
            if ($_SERVER['HTTP_ACCEPT'] == 'application/json'){
                response()->json([
                    'status' => 'error',
                    'answer' => 'method not allowed'
                ], 405);
            }
            abort('Method Not Allowed', 405);
        }
        return false;
    }

    public function withoutCsrfToken(): self
    {
        $this->routes[array_key_last($this->routes)]['needCsrfToken'] = false;
        return $this;
    }

    public function checkCsrfToken(): bool
    {
        return request()->post('csrf_token') && (request()->post('csrf_token') == session()->get('csrf_token'));
    }

    public function middleware(array $middleware=[]): self
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $middleware;
        return $this;
    }

}