<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\HttpServer\Annotation\AutoController;
use Phper666\JwtAuth\Jwt;
use Hyperf\HttpServer\Annotation\Middleware;
use App\Middleware\JwtAuthMiddleware;
use Hyperf\Di\Annotation\Inject;

/**
 * @AutoController()
 * @Middleware(JwtAuthMiddleware::class)
 */
class JwtController extends AbstractController
{
    /**
     * @Inject()
     * @var Jwt
     */
    protected $jwt;

    /**
     * 模拟登录,获取token
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function login()
    {
        $username = $this->request->input('username');
        $password = $this->request->input('password');
        if ($username && $password) {
            $userData = [
                'uid' => 1,
                'username' => 'lele',
            ];
            $token = (string)$this->jwt->getToken($userData);
            return $this->response->success(['token' => $token]);
        }

        return $this->response->fail(500,'登录失败');
    }

    /**
     * 刷新token，http头部必须携带token才能访问的路由
     * @return mixed
     */
    public function refreshToken()
    {
        $token = $this->jwt->refreshToken();
        $data = [
            'token' => (string)$token,
            'exp' => $this->jwt->getTTL()
        ];
        return $this->response->success($data);
    }

    /**
     * 注销token，http头部必须携带token才能访问的路由
     * @return mixed
     */
    public function logout()
    {
        $this->jwt->logout();
        return $this->response->success();
    }

    /**
     * http头部必须携带token才能访问的路由
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getData()
    {
        $data = [
            'cache_time' => $this->jwt->getTokenDynamicCacheTime(), // 获取token的有效时间，动态的
            'data' => $this->jwt->getParserData()
        ];
        return $this->response->success($data);
    }
}
