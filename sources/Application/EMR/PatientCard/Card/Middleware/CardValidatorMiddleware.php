<?php

declare(strict_types = 1);

namespace Application\EMR\PatientCard\Card\Middleware;


use Engine\DataStructures\StructuredResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Проводит валидацию полей карты пациентов
 *
 * Class CardValidatorMiddleware
 * @package Application\EMR\PatientCard\Card\Middleware
 */
class CardValidatorMiddleware implements MiddlewareInterface
{
    /**
     * Список полей который необходимо проверить на обязательное заполнение
     *
     * @var array
     */
    private $_requiredFields = [
        0 => 'cardNumber',
        1 => 'fullName',
        2 => 'dateBirth',
        3 => 'insuranceCertificate',
        4 => 'policyNumber'
    ];

    private $structuredResponse;

    public function __construct()
    {
        $this->structuredResponse = new StructuredResponse();
    }

    private function camelCaseToDashes(string $fieldName) : string {
        $words = preg_split('/(?<=[a-z])(?=[A-Z])/x', $fieldName);
        foreach ($words as $word){
            $lowerCaseWords[] = lcfirst($word);
        }
        return implode($lowerCaseWords, "-" );
    }

    private function validateRequiredFields(array $validatingData) : bool {
        foreach ($this->_requiredFields as $key => $value){
            if (empty($validatingData[$value])){
                $this->structuredResponse->failed();
                $message = $this->structuredResponse->message('fail', 'Поле не заполнено');
                $field = $this->camelCaseToDashes($value);
                $this->structuredResponse->errors('error', ['message' => $message, 'field' => $field]);
            }else{
                $message = $this->structuredResponse->message('success', 'Поле заполнено');
                $field = $this->camelCaseToDashes($value);
                $this->structuredResponse->complete('content', ['message' => $message, 'field' => $field]);
            }
        }
        if ($this->structuredResponse->_status === 'fail'){
            return false;   //Если валидация провалилась
        }
        return true;
    }

    private function validateFullName(array $fullName) : bool {
        $surname = $fullName[0];
        $firstName = $fullName[1];
        if (!empty($surname && $firstName)){
            return true;
        }
        $this->structuredResponse->failed();
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
        //Получаю список полей на проверку
        $validatingData = $request->getParsedBody();
        //Валидирую поля на обязательное заполнение
        if ($this->validateRequiredFields($validatingData)){
            $fullName = explode(' ', $validatingData['fullName']);
            //Важно, чтобы помимо фамилии было заполнено имя
            if ($this->validateFullName($fullName)){
                return $response = $handler->handle($request);
            }
        }
        return new JsonResponse($this->structuredResponse);
    }
}