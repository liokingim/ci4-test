<?php

namespace App\Services\Resource;

class RequestResource
{
    private $data;

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function get($key)
    {
        return $this->data[$key] ?? null;
    }
}
