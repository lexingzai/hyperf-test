<?php

declare(strict_types=1);

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class ErrorCode extends AbstractConstants
{
    /**
     * @Message("没找到该页面")
     */
    const NOT_FOUND = 404;

    /**
     * @Message("请求方式错误")
     */
    const METHOD_NOT_ALLOWED = 405;

    /**
     * @Message("字段验证错误")
     */
    const VALIDATION_ERROR = 422;

    /**
     * @Message("Server Error")
     */
    const SERVER_ERROR = 500;

    /**
     * @Message("系统参数错误")
     */
    const SYSTEM_INVALID = 700;
}
