<?php

declare(strict_types=1);

namespace App\Controller;


use App\Request\testValidationRequest;
use App\Service\QueueService;
use Elasticsearch\ClientBuilder;
use Hyperf\Elasticsearch\ClientBuilderFactory;
use Hyperf\Guzzle\RingPHP\PoolHandler;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Contract\TranslatorInterface;
use Swoole\Coroutine;

/**
 * @AutoController()
 */
class TestController extends AbstractController
{
    /**
     * @Inject
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @Inject
     * @var QueueService
     */
    protected $service;

    public function testValidation(testValidationRequest $request)
    {
        return $this->response->success();
    }

    public function testAspect()
    {
        $data = [
            'id' => 1,
            'name' => 'lexingzai',
            'aspect' => false
        ];
        return $data;
    }

    public function testTranslator()
    {
        // 只在当前请求或协程生命周期有效
        $this->translator->setLocale('zh_CN');

        echo __('messages.welcome' . PHP_EOL);
        echo trans('messages.welcome' . PHP_EOL);

        return $this->translator->trans('messages.welcome', [], 'zh_CN');
    }

    public function testSession()
    {
        session()->set('foo', 'bar');
//        $this->session->setId('HtuvoLgCwPQlhbYNIn7w1ZOJBqO2JHUHUBVGBhUw');
        $sessionId = session()->getId();
        $data = [
            'foo' => session()->get('foo'),
            'session_id' => $sessionId
        ];
        return $this->response->success($data);
    }

    public function testCache()
    {
        cache()->set('foo','bar');
        return $this->response->success(['foo' => cache()->get('foo')]);
    }

    public function testAsyncQueue()
    {
        //传统方式
//        $this->service->push([
//            'group@hyperf.io',
//            'https://doc.hyperf.io',
//            'https://www.hyperf.io',
//        ],30);
        //注解方式
        $this->service->example([
            'group@hyperf.io',
            'https://doc.hyperf.io',
            'https://www.hyperf.io',
        ]);
        return $this->response->success();
    }

    public function testGuzzleClient()
    {
        return guzzle_client()->get('127.0.0.1:9501')->getBody()->getContents();
    }

    public function testElasticSearch()
    {
        // 如果在协程环境下创建，则会自动使用协程版的 Handler，非协程环境下无改变
//        $builder = $this->container->get(ClientBuilderFactory::class)->create();
//        $client = $builder->setHosts(['elasticsearch:9200'])->build();

        //进程池
        $builder = ClientBuilder::create();
        if (Coroutine::getCid() > 0) {
            $handler = make(PoolHandler::class, [
                'option' => [
                    'max_connections' => 50,
                ],
            ]);
            $builder->setHandler($handler);
        }
        $client = $builder->setHosts(['elasticsearch:9200'])->build();

        return $client->info();
    }
}
