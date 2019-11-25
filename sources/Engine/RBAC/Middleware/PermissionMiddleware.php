<?php

declare(strict_types = 1);

namespace Engine\RBAC\Middleware;


use Engine\AAIS\Domains\Session;
use Engine\RBAC\Domains\PrivilegedUser;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PermissionMiddleware implements MiddlewareInterface
{

    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // TODO: Implement process() method.
        $privilegedUser = (new PrivilegedUser())->init(Session::getId());
        if($privilegedUser->hasPermission($request->getAttribute('permission'))){
            return $response = $handler->handle($request);
        }
    }
}