<?php

declare(strict_types=1);

require_once __DIR__ . '/api/bootstrap.php';

use App\Src\AccessToken;
use App\Src\Auth;
use App\Src\CustomFunctions;
use App\Src\Database;
use App\Src\JWTCodec;
use App\Src\UserGateway;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    CustomFunctions::display_error('This page is only accessible with POST method', 405, ['POST']);
}

/** Get input data */
$data = CustomFunctions::get_http_input();

if (!(array_key_exists('name', $data) &&
    array_key_exists('password', $data))) {
    CustomFunctions::display_error('Provide name and password', 401);
}

$name = $data['name'];
$password = $data['password'];

/** Databse connection */
$db = new Database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
$dbc = $db->getConnection();

/** Get user gateway */
$user_gateway = new UserGateway($dbc);

/** Get user by name */
$user = $user_gateway->get_user_by_name($name);

$auth = new Auth($dbc);
$auth->check_login_credentials($user, $password);

$payload = [
    'sub' => $user['id'],
    'name' => $user['name'],
];

// eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIxOCIsIm5hbWUiOiJ0ZXN0In0-.V6kU9UO0W.dwRxQbusH_Y1SHjnID.z8EevThxjZyQqM-
/** JWT */
$jwtc = new JWTCodec($_ENV['APP_KEY']);
$jwt = $jwtc->encode($payload);
CustomFunctions::output_json([
    'token' => $jwt
]);