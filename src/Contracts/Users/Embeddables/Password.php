<?php namespace Maatwebsite\Usher\Contracts\Users\Embeddables;

interface Password
{

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @param $password
     */
    public function setPassword($password);
}
