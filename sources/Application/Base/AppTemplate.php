<?php

declare(strict_types = 1);

namespace Application\Base;


class AppTemplate
{
    private $_templatesFolder ='sources/Application/Templates/Person/';

    public function render(string $page){

        return require $this->_templatesFolder.'/'.$page.'.php';
        //$p = 'sources/Application/Templates/Person/index.php';
        //return $p;
    }

}
