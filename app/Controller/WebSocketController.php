<?php
declare(strict_types=1);

namespace App\Controller;

use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;
use Swoole\Http\Request;
use Swoole\Server;
use Swoole\Websocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;

class WebSocketController implements OnMessageInterface, OnOpenInterface, OnCloseInterface
{
    public function onMessage(WebSocketServer $server, Frame $frame): void
    {
//        $server->push($frame->fd, $frame->fd . 'Recv: ' . $frame->data);
        $data = json_decode($frame->data);
        if(redis()->sIsMember('websocket', $data->fd)){
            $server->push(intval($data->fd), $frame->fd . ' say ' . $data->content);
        }else{
            $server->push($frame->fd, $data->fd . '不存在');
        }

    }

    public function onClose(Server $server, int $fd, int $reactorId): void
    {
//        var_dump($fd . 'closed');
        redis()->sRemove('websocket',$fd);
    }

    public function onOpen(WebSocketServer $server, Request $request): void
    {
//        $server->push($request->fd, 'Opened');
        redis()->sAdd('websocket',$request->fd);
    }
}