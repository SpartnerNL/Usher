<?php namespace Maatwebsite\Usher\Domain\Shared;

abstract class Embedabble
{

    /**
     * Determine equality with another Value Object
     * @param Embedabble $object
     * @return bool
     */
    public function equals(Embedabble $object)
    {
        return $this == $object;
    }

    /**
     * @return string
     */
    abstract public function toString();

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
