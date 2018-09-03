<?php namespace Maatwebsite\Usher\Services;

class CodeGenerator
{
    /**
     * @return string
     */
    public static function make()
    {
        return str_random(32);
    }
}
