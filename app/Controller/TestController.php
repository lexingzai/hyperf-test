<?php

declare(strict_types=1);

namespace App\Controller;


use App\Request\testValidationRequest;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Contract\TranslatorInterface;

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
}
