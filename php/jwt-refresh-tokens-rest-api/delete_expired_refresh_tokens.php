<?php

declare(strict_types=1);

require_once __DIR__ . '/api/bootstrap.php';

use App\Src\CustomFunctions;
use App\Src\Database;
use App\Src\RefreshTokenGateway;

/** Databse connection */
$db = new Database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
$dbc = $db->getConnection();

$refresh_token_gateway = new RefreshTokenGateway($dbc, $_ENV['APP_KEY']);

$refresh_token_gateway->delete_expired_tokens();

echo "Deleted ¯\_(ツ)_/¯" . PHP_EOL;