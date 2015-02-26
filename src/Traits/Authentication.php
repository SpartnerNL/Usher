<?php namespace Maatwebsite\Usher\Traits;

trait Authentication
{

    /**
     * Get the unique identifier for the user.
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getId();
    }

    /**
     * Get the password for the user.
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->getPassword();
    }
}
