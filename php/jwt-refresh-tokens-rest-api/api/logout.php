<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

use App\Src\CustomFunctions;
use App\Src\Database;
use App\Src\RefreshTokenGateway;

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

/** Delete existing refresh token from the db */
$refresh_token_gateway->delete($token) && CustomFunctions::output_json('Deleted');

