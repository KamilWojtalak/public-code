<?php

namespace App\Src;

use App\Src\Interfaces\AccessTokenInterface;

class AccessToken implements AccessTokenInterface
{
    public function create($payload)
    {
        return base64_encode(json_encode($payload));
    }
}
