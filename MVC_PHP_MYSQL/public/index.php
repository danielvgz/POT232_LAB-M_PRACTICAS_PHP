<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/config/config.php';
require_once ROOT_PATH . '/app/core/Router.php';

$appRouter = new Router();
$appRouter->dispatch();
