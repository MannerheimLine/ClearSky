<?php

declare(strict_types = 1);

namespace Application\Base;


use Engine\Base\Template;

class AppTemplate extends Template
{
    /**
     * AppTemplate constructor.
     */
    public function __construct()
    {
        $this->setLayout();
        $this->setPagesFolder();
    }

    /**
     * Установка Layout
     */
    protected function setLayout() : void {
        $this->_layout = 'resources/templates/application/layout/index.php';
    }

    /**
     * Указывает папку со страницами дляподгрузки
     */
    protected function setPagesFolder() : void {
        $this->_pagesFolder = 'resources/templates/application/pages/';
    }

}
