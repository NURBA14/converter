<?php

namespace App\Base;

use Illuminate\Support\Facades\Validator;

abstract class ServiceBase
{
    protected $data;

    public function load(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function handle(): Response
    {
        $validator = Validator::make($this->data, $this->validateRules());
        if ($validator->fails()) {
            return $this->response(false, "Validator fail", [], $validator->errors()->toArray(), 404);
        }
        $this->data = $validator->validated();
        return $this->handleLogic();
    }

    protected function response(bool $status, string $message, array $data, array $errors, int $statusCode = 200): Response
    {
        return new Response([
            "status" => $status,
            "message" => $message,
            "data" => $data,
            "errors" => $errors
        ], $statusCode);
    }

    abstract protected function handleLogic(): Response;
    abstract protected function validateRules(): array;
}