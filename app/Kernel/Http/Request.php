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
    public function ajax()
    {
        return $this->isXmlHttpRequest();
    }

    /**
     * @return bool
     */
    public function isXmlHttpRequest()
    {
        return 'XMLHttpRequest' == $this->request->getHeader('X-Requested-With');
    }

    /**
     * @return \Hyperf\HttpMessage\Server\Request
     */
    public function request()
    {
        return Context::get(PsrRequestInterface::class);
    }
}
