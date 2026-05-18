<?php

declare(strict_types=1);

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/core/Router.php';

$appRouter = new Router();
$appRouter->dispatch();
