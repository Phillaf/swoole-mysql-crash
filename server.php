#!/usr/bin/env php
<?php
declare(strict_types=1);

use Swoole\Http\Request;
use Swoole\Http\Response;

Swoole\Runtime::enableCoroutine(true, SWOOLE_HOOK_ALL);

$http = new Swoole\Http\Server("0.0.0.0", 80);

$config = (new \Swoole\Database\MysqliConfig())
    ->withHost("mysql")
    ->withDbName("user");
$pool = new \Swoole\Database\MysqliPool($config, 64);


$http->on("request", function (Request $request, Response $response) use ($pool) {
    var_dump($request->server['request_uri'] . " start");
    $mysqli = $pool->get();
    $stmt = $mysqli->prepare("UPDATE users SET name = ? WHERE id = ?");

    $id = 1;
    $name = "phil";
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();

    $pool->put($mysqli);

    $response->write("success");
    $response->end();
    var_dump($request->server['request_uri'] . " end");
});

$http->start();
