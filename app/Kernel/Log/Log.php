<?php
/**
 * Created by PhpStorm.
 * User: lele
 * Date: 20-3-5
 * Time: 下午5:38
 */

namespace App\Kernel\Log;


use Hyperf\Utils\ApplicationContext;
use Hyperf\Logger\LoggerFactory;

class Log
{
    public static function get(string $name = 'app', $group = 'default')
    {
        return ApplicationContext::getContainer()->get(LoggerFactory::class)->get($name, $group);
    }
}