<?php

declare(strict_types = 1);

namespace Engine\RBAC\Middleware;


use Engine\AAIS\Domains\Session;
use Engine\DataStructures\StructuredResponse;
use Engine\RBAC\Domains\PermissionCollection;
use Engine\RBAC\Domains\PrivilegedUser;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;

class PermissionMiddleware implements MiddlewareInterface
{
    const REDIRECT_MODE = 1;
    const RESPONSE_MODE = 2;

    private function comparePermission(string $url){
        $permission = (new PermissionCollection())->get($url);
        return $permission;
    }

    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $url = $request->getQueryParams()['url'];
        $comparingPermission = $this->comparePermission($url);
        if ($comparingPermission->_name === 'permitted'){
            return $response = $handler->handle($request);
        }else{
            if ($comparingPermission->_name === 'patientCardAccess'){
                return $response = $handler->handle($request);
            }else{
                if ($comparingPermission->_mode === self::REDIRECT_MODE){
                    return new RedirectResponse('/', 302);
                }else{
                    $response = new StructuredResponse();
                    $message = $response->message($response::FAIL, $comparingPermission[2]);
                    $response->failed()->incomplete('message', $message);
                    return new JsonResponse($response, 401);
                }
            }
        }
    }
}