<?php
namespace App\Services;

class SampleService
{
    public function doSomething(): void
    {
        throw new \Exception("Sample exception");
    }
}