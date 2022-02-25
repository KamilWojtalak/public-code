<?php

namespace App\Src\Interfaces;

use App\Src\TaskGateway;

interface Controller
{
    public function __construct(
        TaskGateway $gateway,
        int $user_id
    );

    public function processRequest(string $method = 'GET', ?int $id): void;
}
