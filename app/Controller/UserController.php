<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\UserService;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\Di\Annotation\Inject;
use Swoole\Exception;

/**
 * @Controller()
 */
class UserController extends AbstractController
{
    /**
     * @inject()
     * @var UserService
     */
    private $userService;

    /**
     * @RequestMapping(path="index", methods="get")
     */
    public function index()
    {
        var_dump($this->request->getAttribute('test'));
        $res = $this->userService->userList();
        return $this->response->success($res);
    }

    /**
     * @RequestMapping(path="create", methods="post")
     */
    public function create()
    {
        $data = $this->request->all();
        $res = $this->userService->create($data);
        return $this->response->success($res);
    }

    /**
     * @RequestMapping(path="update", methods="put")
     */
    public function update()
    {
        $data = $this->request->all();
        $res = $this->userService->update($data);
        return $this->response->success($res);
    }

    /**
     * @RequestMapping(path="delete/{id}", methods="delete")
     */
    public function delete($id)
    {
        $res = $this->userService->delete($id);
        return $this->response->success($res);
    }

    /**
     * @RequestMapping(path="info/{id}", methods="get")
     */
    public function info($id)
    {
        $res = $this->userService->info($id);
        return $this->response->success($res);
    }

}
