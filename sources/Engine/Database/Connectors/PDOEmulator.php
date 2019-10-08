<?php


namespace Engine\Database\Connectors;


class PDOEmulator
{
    public function getData(){
        return ['1' => 'Data1', '2' => 'Data2'];
    }

}