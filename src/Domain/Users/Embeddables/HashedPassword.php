<?php namespace Maatwebsite\Usher\Domain\Users\Embeddables;

use Assert\Assertion;
use Doctrine\ORM\Mapping as ORM;
use Maatwebsite\Usher\Contracts\Users\Embeddables\HashedPassword as HashedPasswordInterface;

/**
 * @ORM\Embeddable
 */
class HashedPassword extends Password implements HashedPasswordInterface
{

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        Assertion::notNull($password);
        $this->password = $password;
    }
}
