<?php

function app(): Rum\Sandbox\Application
{
    return Rum\Sandbox\Application::$app;
}
function request(): Rum\Sandbox\Request
{
    return app()->request;
}

function response(): Rum\Sandbox\Response
{
    return app()->response;
}

function view($view = '', $data = [], $layout=''): string|Rum\Sandbox\View
{
    if($view){
        return app()->view->render($view,$data, $layout);
    }
    return app()->view;
}

function db(): Rum\Sandbox\Database
{
    return app()->db;
}

function abort($error = '', $code = 404)
{
    response()->setResponseCode($code);
//    echo $code;
    echo view("errors/{$code}", ['error' => $error], false);
    die;
}


function base_url($path=''): string
{
    return PATH.$path;
}

function get_href($address = ''): string
{
    $host = HOST;
    if (empty($host)) return '#';
    $arr = explode(".", $host);
    $location = end($arr);

    if ($location == 'ru') {
        return "https://{$address}.iocode.{$location}";
    } elseif ($location == 'loc') {
        return "http://{$address}.iocode.{$location}";
    } else return '#';
}

function read_env(string $key)
{
    if (!is_file(ROOT.'/.env')) return [];
    $raw = trim((string)file_get_contents(ROOT.'/.env'));
    if ($raw === '') return [];

    // многострочный .env
    $lines = preg_split('/\R/', $raw);
    $out = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || $line[0] === ';') continue;
        $pos = strpos($line, '=');
        if ($pos === false) continue;
        $k = trim(substr($line, 0, $pos));
        $v = trim(substr($line, $pos + 1));
        if ($v !== '' && (($v[0] === '"' && substr($v,-1) === '"') || ($v[0] === "'" && substr($v,-1) === "'"))) {
            $v = substr($v, 1, -1);
        }
        $out[$k] = $v;
    }
    return $out[$key];
}

function makeApiRequest(string $url, $headers=[]): array
{
    $token = read_env('MOYSKLAD_TOKEN');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip');

    $response = curl_exec($ch);
//    dump(json_decode($response, true));
    return json_decode($response, true);
}



