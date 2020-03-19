<?php

declare(strict_types=1);

namespace App\Middleware;

use Phper666\JwtAuth\Exception\TokenValidException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Phper666\JwtAuth\Middleware\JwtAuthMiddleware as BaseJwtAuthMiddleware;

class JwtAuthMiddleware extends BaseJwtAuthMiddleware
{
    //不需要验证路由白名单
    protected $routeWhiteList = [
        'login'
    ];

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $isValidToken = false;
        // 根据具体业务判断逻辑走向，这里假设用户携带的token有效
        $token = $request->getHeader('Authorization')[0] ?? '';
        if (strlen($token) > 0) {
            $token = ucfirst($token);
            $arr = explode($this->prefix . ' ', $token);
            $token = $arr[1] ?? '';
            if (strlen($token) > 0 && $this->jwt->checkToken()) {
                $isValidToken = true;
            }
        }
        //获取请求路由名称
        $arr = explode('/',$request->getUri()->getPath());

        if ($isValidToken || in_array(end($arr),$this->routeWhiteList)) {
            return $handler->handle($request);
        }

        throw new TokenValidException('Token authentication does not pass', 401);
    }
}