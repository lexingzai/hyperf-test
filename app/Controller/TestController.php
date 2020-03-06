<?php

declare(strict_types=1);

namespace App\Controller;


use App\Request\testValidationRequest;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * @AutoController()
 */
class TestController extends AbstractController
{
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
}
