<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Http\Response\DiscountResponse as Response;
use Pimple\Psr11\Container;
use Psr\Http\Message\ServerRequestInterface as Request;

final class StatusController
{
    private const API_NAME = 'teamleader-discounts';

    private const API_VERSION = '1.0.0';

    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function index(Request $request, Response $response): Response
    {
        $this->container->get('db');

        $message = [
            'api' => self::API_NAME,
            'version' => self::API_VERSION,
            'status' => [
                'database' => 'OK',
            ],
        ];

        return $response->withJson($message);
    }
}