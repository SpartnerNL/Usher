<?php namespace Maatwebsite\Usher\Domain\Users\Embeddables;

use Assert\Assertion;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Hashing\Hasher;
use Maatwebsite\Usher\Contracts\Users\Embeddables\HashedPassword as HashedPasswordInterface;

/**
 * @ORM\Embeddable
 */
class HashedPassword extends Password implements HashedPasswordInterface
{

    /**
     * @param        $password
     * @param Hasher $hasher
     * @return static
     */
    public static function make($password, Hasher $hasher = null)
    {
        $hasher = $hasher ?: app('Illuminate\Contracts\Hashing\Hasher');

        return $hasher->make($password);
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        Assertion::notNull($password);
        $this->password = $password;
    }
}
