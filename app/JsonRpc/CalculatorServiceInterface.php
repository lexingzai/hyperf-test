<?php
/**
 * Created by PhpStorm.
 * User: lele
 * Date: 20-3-23
 * Time: 上午9:19
 */

namespace App\JsonRpc;

interface CalculatorServiceInterface
{
    public function add(int $a, int $b): int;
}