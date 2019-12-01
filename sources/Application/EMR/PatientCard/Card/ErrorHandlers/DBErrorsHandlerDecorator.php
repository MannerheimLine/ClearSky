<?php


namespace Application\EMR\PatientCard\Card\ErrorHandlers;


use Engine\Database\ErrorHandlers\DBErrorsHandlerInterface;
use Engine\DataStructures\StructuredResponse;

class DBErrorsHandlerDecorator
{
    const ERROR_CODE = 1;
    const ERROR_MESSAGE = 2;
    const ERROR_1062 = 'Duplicate Key Entrance';

    private $_handler;
    private $_structuredResponse;

    public function __construct(DBErrorsHandlerInterface $handler)
    {
        $this->_handler = $handler;
        $this->_structuredResponse = new StructuredResponse();
    }

    private function unhandled(string $handled) : StructuredResponse {
        $message = $this->_structuredResponse->message($this->_structuredResponse::FAIL, $handled);
        $this->_structuredResponse->failed()->errors(['message' => $message]);
        return $this->_structuredResponse;
    }

    private function decorate_1062(array $handled) : StructuredResponse {
        $this->_structuredResponse->failed();
        $substitution = ['policy-number' => 'полисом', 'insurance-certificate' => 'СНИЛС'];
        $fieldName = str_replace('_', '-', $handled['fieldName']);
        $fieldValue = $handled['fieldValue'];
        $message = $this->_structuredResponse->message('fail', "Карта с таким $substitution[$fieldName] уже существует");
        $this->_structuredResponse->errors(
            ['message' => $message,
            'fieldName' => $fieldName,
            'fieldValue' => $fieldValue,
            'errorType' => self::ERROR_1062]);
        return $this->_structuredResponse;
    }

    public function handleException(\PDOStatement $statement){
        /**
         * Первым делом получаю код ошибки, чтобы знать какое действие для обработки выбрать
         */
        $errorInfo = $statement->errorInfo();
        /**
         * Далее нужно вычислить необходимы метод для обработки ошибок
         * Если метод для обработки уже написан, то выполняю его
         */
        $method = 'decorate_'.$errorInfo[self::ERROR_CODE];
        $handled = $this->_handler->handleException($statement);
        /**
         * Декорирую полученный результат, выполняя нужный методЮ либо дефолтный unhandled
         */
        if (method_exists($this, $method)){

            return $this->$method($handled);
        }else{
            return $this->unhandled($handled);
        }
    }

}