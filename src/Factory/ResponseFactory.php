<?php

declare(strict_types=1);

namespace App\Factory;

use App\Http\Response\DiscountResponse;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;

final class ResponseFactory implements ResponseFactoryInterface
{
    public function createResponse(
        int    $code = StatusCodeInterface::STATUS_OK,
        string $reasonPhrase = ''
    ): Response
    {
        return (new DiscountResponse())->withStatus($code, $reasonPhrase);
    }
}