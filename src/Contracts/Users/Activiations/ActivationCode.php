<?php namespace Maatwebsite\Usher\Contracts\Users\Activiations;

interface ActivationCode
{

    /**
     * @return mixed
     */
    public function getCode();

    /**
     * @param mixed $code
     */
    public function setCode($code);

    /**
     * @return Token
     */
    public static function generate();

    /**
     * @return string
     */
    public function toString();
}
