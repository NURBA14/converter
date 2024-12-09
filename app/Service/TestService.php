<?php

namespace App\Service;

use App\Base\Response;
use App\Base\ServiceBase;
use LDAP\Result;

class TestService extends ServiceBase
{
    protected function handleLogic(): Response
    {
        return $this->response(false, "Wasd", $this->data, [], 200);
    }

    protected function validateRules(): array
    {
        return [
            "test" => "required"
        ];
    }
}