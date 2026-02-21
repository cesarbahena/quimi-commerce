<?php

use QuimiCommerce\Kernel;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__.'/../vendor/autoload.php';

$_SERVER['APP_ENV'] ??= $_ENV['APP_ENV'] ?? 'dev';
$_SERVER['APP_DEBUG'] ??= $_ENV['APP_DEBUG'] ?? '1';

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$request = Request::createFromGlobals();

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
