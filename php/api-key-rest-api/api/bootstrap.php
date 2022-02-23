<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

/** .ENV initialization */
$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

/** Require config file */
require_once dirname(__DIR__) . '/config.php';

/** Set error and exception handler */
set_error_handler('App\Src\ExceptionHandler::handle_error');
set_exception_handler('App\Src\ExceptionHandler::handle_exception');

// Set content type to json and charset
header('Content-type: application/json; charset=UTF-8');
