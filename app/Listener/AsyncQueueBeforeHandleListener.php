<?php

declare(strict_types=1);

namespace App\Listener;

use Hyperf\AsyncQueue\Event\BeforeHandle;
use Hyperf\Event\Annotation\Listener;
use Psr\Container\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;

/**
 * @Listener
 */
class AsyncQueueBeforeHandleListener implements ListenerInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function listen(): array
    {
        return [
            BeforeHandle::class,
        ];
    }

    public function process(object $event)
    {
        var_dump('async_queue_before_handle');
    }
}
