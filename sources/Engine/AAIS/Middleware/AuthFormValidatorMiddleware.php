<?php


namespace Engine\AAIS\Middleware;


use Engine\DataStructures\StructuredResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class AuthFormValidatorMiddleware implements MiddlewareInterface
{
    private $_structuredResponse;

    public function __construct()
    {
        $this->_structuredResponse = new StructuredResponse();
    }

    private function validateRequired(array $fields) : bool {
        foreach ($fields as $field){
            if (empty($field)){
                $this->_structuredResponse->failed();
                $message = $this->_structuredResponse->message('fail', 'Поле должно быть заполнено');
                $this->_structuredResponse->incomplete('response', ['message' => $message]);
            }else{
                $this->_structuredResponse->success();
            }
        }
        if ($this->_structuredResponse->_status === 'fail'){
            return false;
        }
        return true;
    }

    private function validateUserName(string $userName) : bool {
        $string = trim($userName);
        if(preg_match("(^[A-Za-z0-9]+$)", $string)){
            $this->_structuredResponse->success();
            return true;
        }
        $this->_structuredResponse->failed();
        $message = $this->_structuredResponse->message('fail', 'Учетная запись не допускает наличия спецсимволов типа: !@#$%^&&*(.');
        $this->_structuredResponse->incomplete('response', ['message' => $message]);
        return false;
    }

    private function validatePassword(string $password) : bool {
        $string = trim($password);
        if(preg_match("(^[A-Za-z0-9!@#$%^&*()-]+$)", $string)){
            $this->_structuredResponse->success();
            return true;
        }
        $this->_structuredResponse->failed();
        $message = $this->_structuredResponse->message('fail', 'Недопустимые символы в пароле! Разрешены: буквы и !@#$%^&*()- символы');
        $this->_structuredResponse->incomplete('response', ['message' => $message]);
        return false;
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
        $userName = $request->getParsedBody()['login'];
        $password = $request->getParsedBody()['password'];
        if ($this->validateRequired([$userName, $password])){
            if ($this->validateUserName($userName)){
                if ($this->validatePassword($password)){
                    return $response = $handler->handle($request);
                }else{
                    //Недопустимые символы в пароле
                }
            }else{
                //Не допустимые символы в имени
            }
        }else{
            //поля не заполнены
        }
        return new JsonResponse($this->_structuredResponse);
    }
}
