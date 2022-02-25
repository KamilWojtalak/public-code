<?php

namespace App\Src\Interfaces;

interface AccessTokenInterface
{
    public function create($payload);
}
