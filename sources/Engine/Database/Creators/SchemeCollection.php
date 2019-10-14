<?php

declare(strict_types = 1);

namespace Engine\Database\Creators;


use Engine\Database\Creators\DataStructures\Scheme;

class SchemeCollection
{
    private $_schemes = [];

    public function __construct(string $schemesFolder)
    {
        $this->init($schemesFolder);
    }

    private function init(string $schemesFolder) {
        $schemeFiles = array_slice(scandir($schemesFolder), 2);
        foreach ($schemeFiles as $schemeFile){
            $this->_schemes[] = new Scheme($schemeFile);
        }
    }

    public function getScheme(){

    }


}
