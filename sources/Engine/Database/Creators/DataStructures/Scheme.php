<?php

declare(strict_types = 1);

namespace Engine\Database\Creators\DataStructures;


class Scheme
{
    private $_info = [];
    private $_fields = [];

    public function __construct(array $scheme)
    {
        $this->serialize($scheme);
    }

    private function serialize(array $schema){
        $this->_info = $schema['info'];
        $this->_fields = $schema['fields'];
    }

    public function getInfo(){
        return $this->_info;
    }

    public function getFields(){
        return $this->_fields;
    }

}