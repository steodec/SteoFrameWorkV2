<?php

use Steodec\SteoFrameWork\Router\Router;
use function DI\create;

return [
    PDO::class => fn() => new PDO($_ENV['DATABASE_DSN'], $_ENV['DATABASE_USERNAME'], $_ENV['DATABASE_PASSWORD']),
    Router::class => create(),
];
