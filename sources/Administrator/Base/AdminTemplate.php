<?php

declare(strict_types = 1);

namespace Administrator\Base;


use Engine\Base\Template;

class AdminTemplate extends Template
{
    public function __construct()
    {
        $this->setLayout();
        $this->setPagesFolder();
    }

    /**
     * Установка Layout
     */
    protected function setLayout(): void
    {
        $this->_layout = 'resources/templates/administrator/layout/index.php';
    }

    /**
     * Указывает папку со страницами дляподгрузки
     */
    protected function setPagesFolder(): void
    {
        $this->_pagesFolder = 'resources/templates/administrator/pages/';
    }
}