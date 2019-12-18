<?php

declare(strict_types = 1);

namespace Application\EMR\Talons\Base;


abstract class Talon
{
    protected $_talonStyle;
    protected $_talonTemplate;
    protected $_talonsFolder;
    protected $_pdfConfigs = [];

    public function __construct()
    {
        $this->setFolder('resources/templates/application/pages/talons');
        $this->setStylesheet('resources/templates/application/layout/css/talon.css');
    }

    protected function setPdfConfigs(array $params){
        $this->_pdfConfigs = $params;
    }

    /**
     * Устанавливает папку, где хранятся HTML шаблоны талонов
     *
     * @param string $path
     */
    protected function setFolder(string $path) : void {
        $this->_talonsFolder = $path;
    }

    /**
     * Устанавливает папку где хранятся стили для талонов
     *
     * @param string $path
     */
    protected function setStylesheet(string $path){
        $this->_talonStyle = $path;
    }

    /**
     * Устанавливает имя шаблона для подгрузки
     *
     * @param string $templateName
     */
    protected function setTemplate(string $templateName){
        $this->_talonTemplate = $templateName;
    }

    /**
     * Подготавливает шаблон к загрузке
     *
     * @return string
     */
    protected function prepareHtml(array $talonData) : string {
        ob_start();
        include $this->_talonsFolder.'/'.$this->_talonTemplate.'.php';
        $html = ob_get_clean();
        return $html;
    }

    /**
     * Загрузка данных
     *
     * @return mixed
     */
    abstract public function getTalonData(int $cardId);

    /**
     * Вывод на печать готового PDF талона
     *
     * @return mixed
     */
    abstract public function makePdf(int $cardId);

}