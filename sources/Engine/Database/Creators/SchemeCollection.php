<?php

declare(strict_types = 1);

namespace Engine\Database\Creators;


use Engine\Database\Creators\DataStructures\Scheme;

class SchemeCollection
{
    private $_schemes = [];
    private $_availableExtensions = [
        'php'
    ];

    public function __construct(string $schemesFolder)
    {
        $this->init($schemesFolder);
    }

    private function init(string $schemesFolder) {
        $schemeFiles = array_slice(scandir($schemesFolder), 2);
        foreach ($schemeFiles as $schemeFile){
            $extension  = pathinfo($schemeFile, PATHINFO_EXTENSION);
            if (in_array($extension, $this->_availableExtensions)){
                $schemeFile = include $schemesFolder.'/'.$schemeFile;
                $this->_schemes[] = new Scheme($schemeFile);
            }

        }
    }

    public function getSchemes(){
        return $this->_schemes;
    }


}
