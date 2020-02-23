<?php

declare(strict_types = 1);

namespace Application\Base;


class AppDomain
{
    protected function sanitize($string) : string {
        $convertedString = mb_convert_encoding($string, "utf-8");
        return preg_replace ("/[^a-zA-ZА-Яа-я0-9\s-]/ui","", $convertedString);
    }

    protected function sanitizeToInt(string $string){
        $convertedString = mb_convert_encoding($string, "utf-8");
        return (int)preg_replace ("/[^0-9]/ui","", $convertedString) ?: null;
    }

    protected function sanitizeToString($string){
        $convertedString = mb_convert_encoding($string, "utf-8");
        return preg_replace ("/[^a-zA-ZА-Яа-я0-9]/ui","", $convertedString) ?: null;
    }

    protected function camelCaseToDashes(string $fieldName) : string {
        $words = preg_split('/(?<=[a-z])(?=[A-Z])/x', $fieldName);
        foreach ($words as $word){
            $lowerCaseWords[] = lcfirst($word);
        }
        return implode($lowerCaseWords, "-" );
    }

}
