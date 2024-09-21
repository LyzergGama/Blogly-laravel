<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$request = Request::capture();

$response = $app->make(Kernel::class)->handle($request);

$response->send();

$app->terminate($request, $response);
