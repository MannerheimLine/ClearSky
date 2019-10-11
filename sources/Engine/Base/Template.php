<?php

declare(strict_types = 1);

namespace Engine\Base;


abstract class Template
{
    protected $_pagesFolder;
    protected $_title;
    protected $_layout;

    /**
     * Установка Layout
     */
    abstract protected function setLayout() : void ;

    /**
     * Указывает папку со страницами дляподгрузки
     */
    abstract protected function setPagesFolder() : void;

    /**
     * Установка титула страницы. Нужен ли при условии использования JS?
     * -----------------------------------------------------------------
     * @param string $title
     */
    public function setTitle(string $title) : void {
        $this->_title = $title;
    }

    /**
     * Подгружает layout
     * -------------------
     * @param string $page
     * @param $data
     * @return string
     */
    public function render(string $page, $data) : string {
        ob_start();
        include $this->_layout;
        $html = ob_get_clean();
        return $html;
    }

}
