<?php


namespace Engine\Database\ErrorHandlers;


interface DBErrorsHandlerInterface
{
    /**
     * @param \PDOStatement $statement
     * @return mixed
     */
    public function handleException(\PDOStatement $statement);
}