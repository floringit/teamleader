<?php

declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use \Slim\Psr7\Response;
use Slim\App;

return static function (App $app): void {
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function (Request $request): Response {
            $response = (new Response())->withStatus(404);
            $response->getBody()->write('404 Not found');

            return $response;
        }
    );
};