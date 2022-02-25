<?php

use App\Src\CustomFunctions;

$payload = [
    'sub' => $user['id'],
    'name' => $user['name'],
    /** Expiration time of 5 minutes */
    'exp' => time() + JWT_ACCESS_TOKEN_EXPIRATION_TIME,
];

/** Access token */
$jwt = $jwtc->encode($payload);
/** Refresh token */
$refresh_token = $jwtc->encode([
    'sub' => $user['id'],
    'exp' => $jwtc->get_refresh_token_exp()
]);

CustomFunctions::output_json([
    'access_token' => $jwt,
    'refresh_token' => $refresh_token,
]);
