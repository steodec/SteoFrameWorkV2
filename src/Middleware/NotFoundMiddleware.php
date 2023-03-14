<?php
namespace Steodec\SteoFrameWork\Middleware;

use Psr\Http\Message\ServerRequestInterface;

class NotFoundMiddleware
{

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        return new Response(404, [], 'Erreur 404');
    }
}
