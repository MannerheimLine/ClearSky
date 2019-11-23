<?php


namespace Engine\AAIS\Base;


use Engine\Base\Template;

class LoginTemplate extends Template
{
    public function __construct()
    {
        $this->setLayout();
    }

    /**
     * Установка Layout
     */
    protected function setLayout(): void
    {
        $this->_layout = 'resources/templates/login/layout/index.php';
    }

    /**
     * Указывает папку со страницами дляподгрузки
     */
    protected function setPagesFolder(): void
    {
        // TODO: Implement setPagesFolder() method.
    }
}