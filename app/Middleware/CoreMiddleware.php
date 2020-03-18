<?php
declare(strict_types=1);

namespace App\Middleware;

use Hyperf\Utils\Contracts\Arrayable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Hyperf\HttpServer\CoreMiddleware as HyperfCoreMiddleware;
use App\Kernel\Http\Response;
use Hyperf\Di\Annotation\Inject;

class CoreMiddleware extends HyperfCoreMiddleware
{
    /**
     * @Inject
     * @var Response
     */
    protected $response;

    /**
     * Handle the response when cannot found any routes.
     *
     * @return array|Arrayable|mixed|ResponseInterface|string
     */
    protected function handleNotFound(ServerRequestInterface $request)
    {
        // 重写路由找不到的处理逻辑
        return $this->response->fail(404,'访问路由不存在');
    }

    /**
     * Handle the response when the routes found but doesn't match any available methods.
     *
     * @return array|Arrayable|mixed|ResponseInterface|string
     */
    protected function handleMethodNotAllowed(array $methods, ServerRequestInterface $request)
    {
        // 重写 HTTP 方法不允许的处理逻辑
        return $this->response->fail(405,'请求方式错误');
    }
}