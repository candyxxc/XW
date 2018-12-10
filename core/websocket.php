<?php
include 'Route.php';
include 'redis_curd.php';

class WebSocket
{
    public function __construct()
    {
        $ws = new swoole_websocket_server("0.0.0.0", 9501);

        $ws->set([
            'http_compression' => false
        ]);
        $ws->on('request', [$this, 'onRequest']);
        $ws->on('open', [$this, 'onOpen']);
        $ws->on('message', [$this, 'onMessage']);
        $ws->on('close', [$this, 'onClose']);
        $ws->start();
    }

    public function onRequest($request, $response)
    {
        spl_autoload_register(function ($className) use ($response) {
            try {
                Route::load($className);
            } catch (Exception $e) {
                $response->status(404);
                $response->end($e->getMessage());
            }
        });
        new Route($request, $response);
    }

    public function onOpen($server, $request)
    {
        redis_curd::getSource()->sAdd('number', $request->fd);
        $server->push($request->fd, redis_curd::getSource()->sCard('number'));
        $number = redis_curd::getSource()->sMembers('number');
        foreach ($number as $n) {
            if (!($n == $request->fd)) {
                $server->push($n, $request->fd . "Join in room");
            }
        }
        $server->push($request->fd, "Welcome to TangoXXC");
    }

    public function onMessage($server, $request)
    {
        $number = redis_curd::getSource()->sMembers('number');
        foreach ($number as $n) {
            if (!($n == $request->fd)) {
                $server->push($n, $request->fd . ":" . $request->data);
            }
        }
    }

    public function onClose($ser, $fd)
    {
        redis_curd::getSource()->sRem('number', $fd);
    }
}

new WebSocket();
