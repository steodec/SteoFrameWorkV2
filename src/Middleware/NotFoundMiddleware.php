<?php
namespace Steodec\SteoFrameWork\Middleware;

use http\Client\Response;
use Psr\Http\Message\ServerRequestInterface;

class NotFoundMiddleware
{

    public function __invoke(ServerRequestInterface $request, callable $next): Response
    {
        return new Response(404, [], 'Erreur 404');
    }
}
