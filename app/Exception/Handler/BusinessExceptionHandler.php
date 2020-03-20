<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Exception\Handler;

use App\Kernel\Log\Log;
use Hyperf\Di\Annotation\Inject;
use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Kernel\Http\Response;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class BusinessExceptionHandler extends ExceptionHandler
{
    /**
     * @Inject
     * @var Response
     */
    protected $response;

    /**
     * @Inject()
     * @var StdoutLoggerInterface
     */
    protected $logger;

    /**
     * @var LoggerFactory
     */
    protected $loggerFactory;

    public function __construct(LoggerFactory $loggerFactory)
    {
        // 第一个参数对应日志的 name, 第二个参数对应 config/autoload/logger.php 内的 key
        $this->loggerFactory = $loggerFactory->get('log', 'default');
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if($code = $this->shouldReturn($throwable)){
            if($throwable instanceof ValidationException){
                //三种日志记录方法
//                $this->loggerFactory->info(format_throwable($throwable));//记录到日志文件
                Log::get()->info(format_throwable($throwable));//记录到日志文件
                $this->logger->info(format_throwable($throwable));//打印到控制台 如果dependencies配置文件开启日志接管的话 日志就会记录到日志文件


                return $this->response->fail($throwable->status, $throwable->validator->errors()->first());
            }
            return $this->response->fail($code, ErrorCode::getMessage($code));
        }

        if ($throwable instanceof BusinessException) {
            $this->logger->warning(format_throwable($throwable));

            return $this->response->fail($throwable->getCode(), $throwable->getMessage());
        }

        $this->logger->error(format_throwable($throwable));

        //debug模式下显示错误信息
        if(env('APP_ENV') == 'local'){
            return $this->response->fail($throwable->getCode(), $throwable->getMessage());
        }

        return $this->response->fail($code = ErrorCode::SERVER_ERROR, ErrorCode::getMessage($code));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }

    /**
     * 当抛出这些异常时，可以使用我们定义的错误信息与HTTP状态码
     * 可以把常见异常放在这里
     * @var array
     */
    public $doReport = [
        \Hyperf\Validation\ValidationException::class => ErrorCode::VALIDATION_ERROR,
        \Hyperf\Server\Exception\InvalidArgumentException::class => ErrorCode::INVALID_ARGUMENT_ERROR,
    ];

    /**
     * @param Throwable $throwable
     * @return bool|mixed
     */
    public function shouldReturn(Throwable $throwable)
    {
        foreach (array_keys($this->doReport) as $report){
            if ($throwable instanceof $report){
                return $this->doReport[$report];
            }
        }

        return false;
    }
}
