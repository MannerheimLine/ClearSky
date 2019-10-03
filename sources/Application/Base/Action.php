<?php


namespace Application\Base;


class Action
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