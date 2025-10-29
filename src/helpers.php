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
    if (empty($headers)){
        $token = read_env('MOYSKLAD_TOKEN');

        $headers = array(
            "Authorization: Bearer {$token}",
            "Accept-Encoding: gzip",
            "Lognex-Pretty-Print-JSON: true"
        );
    };


    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip');

    $response = curl_exec($ch);
//    dump(json_decode($response, true));
    return json_decode($response, true);
}

function downloadImage($url, $pathBase, $headers, $id) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_HEADER, true);
    $data = curl_exec($ch);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headersStr = substr($data, 0, $header_size);
    $body = substr($data, $header_size);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);
    curl_close($ch);

    if ($code == 200 && $body) {
        $ext = '.jpg';
        if (preg_match('/Content-Type:\s*(image\/\w+)/i', $headersStr, $m)) {
            switch ($m[1]) {
                case 'image/png':  $ext = '.png';  break;
                case 'image/webp': $ext = '.webp'; break;
                case 'image/jpeg': $ext = '.jpg';  break;
            }
        }
        $path = $pathBase . $ext;

//        dd('v');
        file_put_contents($path, $body);
        if (filesize($path) < 10) {
            file_put_contents(__DIR__.'/../logs/msk_img_error.log', "[".date('c')."] id=$id file too small\n", FILE_APPEND);
            @unlink($path);
            return null;
        }
        return $path;
    } else {
        file_put_contents(__DIR__.'/../logs/msk_img_error.log', "[".date('c')."] id=$id url=$url ERR=$err\n", FILE_APPEND);
    }
    return null;
}



