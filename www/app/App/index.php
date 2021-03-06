<?php

define('_APP_PATH_', __DIR__);

define('_APP_PATH_VIEW_', __DIR__ . '/View');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/lizhichao/one/src/run.php';
require __DIR__ . '/config.php';

try {
    \One\Http\Router::loadRouter();
    $req = new \One\Http\Request();
    $res = new \One\Http\Response($req);

    $router = new \One\Http\Router();
    list($req->class, $req->method, $mids, $action, $req->args) = $router->explain($req->method(), $req->uri(), $req, $res);
    $f = $router->getExecAction($mids, $action, $res);
    echo $f();
} catch (\One\Exceptions\HttpException $e) {
    echo \One\Exceptions\Handler::render($e);
} catch (Throwable $e) {
    error_report($e);
    echo \One\Exceptions\Handler::render(new \One\Exceptions\HttpException($res, $e->getMessage(), $e->getCode()));
}

