<?php

namespace App\Src;

class AccessToken
{
    public function create($payload)
    {
        return base64_encode(json_encode($payload));
    }
}
