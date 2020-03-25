<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;

/**
 * @AutoController
 */
class ViewController
{
    public function index()
    {
        return view('index', ['name' => 'Hyperf']);
    }

    public function webSocket()
    {
        return view('websocket');
    }
}