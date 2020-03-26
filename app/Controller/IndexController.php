<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

class IndexController extends AbstractController
{
    public function index()
    {
        var_dump(\Hyperf\Utils\Coroutine::id());
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();
        $data = [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
        return $this->response->success($data);
    }
}
