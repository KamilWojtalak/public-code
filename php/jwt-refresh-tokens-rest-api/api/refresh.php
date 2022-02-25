<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

use App\Src\CustomFunctions;
use App\Src\Database;
use App\Src\JWTCodec;
use App\Src\RefreshTokenGateway;
use App\Src\UserGateway;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') CustomFunctions::display_error('This page is only accessible with POST method', 405, ['POST']);

/** Databse connection */
$db = new Database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
$dbc = $db->getConnection();

$refresh_token_gateway = new RefreshTokenGateway($dbc, $_ENV['APP_KEY']);

/** Get input data */
$data = CustomFunctions::get_http_input();

/** Check if there is token in data */
if (!(array_key_exists('token', $data))) CustomFunctions::display_error('Provide token', 401);

/** Get refresh token */
$token = $data['token'];

/** If there is not token in the db throw error */
if (!$refresh_token_gateway->get_token_by_token($token)) CustomFunctions::display_error('Invalid token (not on the whitelist)', 422);

$jwtc = new JWTCodec($_ENV['APP_KEY']);
$payload = $jwtc->decode($token);

/** Get user id */
$user_id = +$payload['sub'];

/** Get user gateway */
$user_gateway = new UserGateway($dbc);

/** Get user by name */
$user = $user_gateway->get_user_by_id($user_id);

if (!$user) CustomFunctions::display_error('Invalid authentication', 401);

require __DIR__ . '/token.php';

/** Delete existing refresh token from the db */
$refresh_token_gateway->delete($token);
/** Add new refresh token to the db */
$refresh_token_gateway->create($refresh_token, $jwtc->get_refresh_token_exp());