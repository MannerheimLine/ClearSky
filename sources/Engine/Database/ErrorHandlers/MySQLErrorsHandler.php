<?php


namespace Engine\Database\ErrorHandlers;


class MySQLErrorsHandler implements DBErrorsHandlerInterface
{
    const ERROR_CODE = 1;
    const ERROR_MESSAGE = 2;

    /**
     * Вернет имя поля и значение поля нарушающее его уникальность
     *
     * @param \PDOStatement $statement
     * @return array
     */
    private function handle_1062(\PDOStatement $statement) : array {
        $errorInfo = $statement->errorInfo(); //[23000, 1062, "Duplicate entry ..."]
        if (preg_match_all('/\'([^\']+)+\'/', $errorInfo[self::ERROR_MESSAGE], $matches)) {
            $fieldName = $matches[1][1];
            $fieldValue = $matches[1][0];
        }
        $handled = ['fieldName' => $fieldName, 'fieldValue' => $fieldValue];
        return $handled;
    }

    /**
     * Вернет сообщение с кодом ошибки, для которой не создан обработчик.
     *
     * @param \PDOStatement $statement
     * @return string
     */
    private function unhandled(\PDOStatement $statement) : string {
        $errorInfo = $statement->errorInfo();
        return 'Обработчик для текущей ошибки еще не создан. Код ошибки '.$errorInfo[self::ERROR_CODE];
    }

    /**
     * @param \PDOStatement $statement
     * @return mixed|string
     */
    public function handleException(\PDOStatement $statement){
        /**
         * Первым делом получаю код ошибки, чтобы знать какое действие для обработки выбрать
         */
        $errorInfo = $statement->errorInfo();
        /**
         * Далее нужно вычислить необходимы метод для обработки ошибок
         * Если метод для обработки уже написан, то выполняю его
         */
        $method = 'handle_'.$errorInfo[self::ERROR_CODE];
        if (method_exists($this, $method)){
            return $this->$method($statement);
        }else{
            return $this->unhandled($statement);
        }
    }

}