<?php

declare(strict_types=1);

namespace App\Kernel\Http;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Context;
use Psr\Http\Message\RequestInterface as PsrRequestInterface;

class Request
{
    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * @return bool
     */
    public function isAjax()
    {
        return 'XMLHttpRequest' == $this->request->getHeader('X-Requested-With');
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return $this->request->isMethod('post');
    }

    /**
     * @return bool
     */
    public function isGet()
    {
        return $this->request->isMethod('get');
    }

    /**
     * @return \Hyperf\HttpMessage\Server\Request
     */
    public function request()
    {
        return Context::get(PsrRequestInterface::class);
    }
}
