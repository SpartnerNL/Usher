<?php namespace Maatwebsite\Usher\Contracts\Users\Embeddables;

interface Email
{

    /**
     * @return mixed
     */
    public function getEmail();

    /**
     * @param mixed $email
     */
    public function setEmail($email);
}
