<?php


namespace Application\Base;


class AppAction
{
    protected $_variable;

    public function __construct()
    {
        $this->_variable = 'This is protected Variable';
    }

    protected function AnotherHeader(){
        return 'Another Header';
    }

}