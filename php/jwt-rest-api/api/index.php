<?php

declare(strict_types=1);

namespace App\Api;

use App\Src\Auth;
use App\Src\CustomFunctions;
use App\Src\Database;
use App\Src\JWTCodec;
use App\Src\TaskGateway;
use App\Src\TasksController;
use App\Src\UserGateway;

require_once __DIR__ . '/bootstrap.php';

/** Instantiate db class and get connection */
$dbi = new Database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
$dbc = $dbi->getConnection();

/** Utilities used mainly in this file */
$api = new Api();

/** Auth instance */
$auth = new Auth($dbc);

// Get authrozation header
$authrozation_header = $auth->get_authorization_header();
$auth->authenticate_jwt($authrozation_header);

/** Get id of current user */
$user_id = $auth->get_user_id();

/** Get URL */
$url = $api->delete_query_string($_SERVER['REQUEST_URI']);
/** Get URL method */
$url_method = $_SERVER['REQUEST_METHOD'];

/** Get the resource from URL */
$rest_resource = $api->get_url_resource($url);

/** Resource that are handled by our app */
$allowed_resources = $api->get_allowed_resources();

/** Check if user requested valid resource */
$api->check_if_valid_resource($rest_resource, $allowed_resources);

/** GET resource ID if there is one */
$url_id = $api->get_url_id($url);

/** HTTP methods that are allowed to serve our requests */
$allowed_resources_methods = $api->get_allowed_resources_methods();
$allowed_resources_methods_with_id = $api->get_allowed_resources_methods_with_id();

/** Look for proper id and method */
$api->check_if_there_is_proper_method_or_id($url_id, $url_method, $allowed_resources_methods, $allowed_resources_methods_with_id);

/** Instantiate TaskGateway class */
$task_gateway = new TaskGateway($dbc);

/** Statically call TaskController */
$task_controller = new TasksController($task_gateway, $user_id);

/** Handle task request */
$task_controller->processRequest($url_method, $url_id);
