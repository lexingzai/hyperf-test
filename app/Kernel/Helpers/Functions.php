<?php

declare(strict_types=1);

use Hyperf\Amqp\Message\ProducerMessageInterface;
use Hyperf\Amqp\Producer;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\JobInterface;
use Hyperf\ExceptionHandler\Formatter\FormatterInterface;
use Hyperf\Utils\ApplicationContext;
use Swoole\Websocket\Frame;
use Hyperf\Server\ServerFactory;
use Swoole\WebSocket\Server as WebSocketServer;
use Hyperf\View\RenderInterface;
use Psr\SimpleCache\CacheInterface;
use Hyperf\Contract\SessionInterface;
use Hyperf\Guzzle\ClientFactory;
use Hyperf\Guzzle\HandlerStackFactory;
use GuzzleHttp\Client;

if (! function_exists('di')) {
    /**
     * Finds an entry of the container by its identifier and returns it.
     * @param null|mixed $id
     * @return mixed|\Psr\Container\ContainerInterface
     */
    function di($id = null)
    {
        $container = ApplicationContext::getContainer();
        if ($id) {
            return $container->get($id);
        }

        return $container;
    }
}

if (! function_exists('format_throwable')) {
    /**
     * Format a throwable to string.
     */
    function format_throwable(Throwable $throwable): string
    {
        return di()->get(FormatterInterface::class)->format($throwable);
    }
}

if (! function_exists('queue_push')) {
    /**
     * Push a job to async queue.
     */
    function queue_push(JobInterface $job, int $delay = 0, string $key = 'default'): bool
    {
        $driver = di()->get(DriverFactory::class)->get($key);
        return $driver->push($job, $delay);
    }
}

if (! function_exists('amqp_produce')) {
    /**
     * Produce a amqp message.
     */
    function amqp_produce(ProducerMessageInterface $message): bool
    {
        return di()->get(Producer::class)->produce($message, true);
    }
}

if (!function_exists('container')) {
    function container()
    {
        return ApplicationContext::getContainer();
    }
}

if (!function_exists('redis')) {
    function redis()
    {
        return container()->get(Redis::class);
        // 通过 DI 容器获取或直接注入 RedisFactory 类
//        return container()->get(\Hyperf\Redis\RedisFactory::class)->get('foo');
    }
}

if (!function_exists('server')) {
    function server()
    {
        return container()->get(ServerFactory::class)->getServer()->getServer();
    }
}

if (!function_exists('frame')) {
    function frame()
    {
        return container()->get(Frame::class);
    }
}

if (!function_exists('websocket')) {
    function webSocket()
    {
        return container()->get(WebSocketServer::class);
    }
}

if (!function_exists('view')) {
    function view(string $template, array $data = [])
    {
        return container()->get(RenderInterface::class)->render($template, $data);
    }
}

if (!function_exists('cache')) {
    function cache()
    {
        return container()->get(CacheInterface::class);
    }
}

if (!function_exists('session')) {
    function session()
    {
        return container()->get(SessionInterface::class);
    }
}

if (!function_exists('guzzle_client')) {
    function guzzle_client()
    {
        $options = [];
        $middlewares = [];
        //非Guzzle连接池
        //return container()->get(ClientFactory::class)->create($options);
        //Guzzle连接池
        $factory = new HandlerStackFactory();
        $stack = $factory->create($options, $middlewares);

        return make(Client::class, [
            'config' => [
                'handler' => $stack,
            ],
        ]);
    }
}

