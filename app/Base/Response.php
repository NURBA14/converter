<?php

namespace App\Base;

class Response
{
    private $data;
    private $statusCode;
    public function __construct(array $data, int $statusCode)
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
    }


    public function json()
    {
        return response()->json($this->data, $this->statusCode);
    }

    public function php()
    {
        return $this->data;
    }
}