<?php namespace Maatwebsite\Usher\Domain\Users\Embeddables;

use Assert\Assertion;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Hashing\Hasher;
use Maatwebsite\Usher\Domain\Shared\Embedabble;
use Maatwebsite\Usher\Contracts\Users\Embeddables\Password as PasswordInterface;

/**
 * @ORM\Embeddable
 */
class Password extends Embedabble implements PasswordInterface
{

    /**
     * @ORM\Column(type = "string")
     * @var string
     */
    protected $password;

    /**
     * @var int
     */
    const MIN = 6;

    /**
     * @var int
     */
    const MAX = 30;

    /**
     * @var Hasher
     */
    protected $hasher;

    /**
     * @param string $password
     * @param Hasher $hasher
     */
    public function __construct($password, Hasher $hasher = null)
    {
        $this->hasher = $hasher;
        $this->setPassword($password);
    }

    /**
     * @return HashedPassword
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        Assertion::betweenLength($password, self::MIN, self::MAX);
        $this->password = HashedPassword::make(
            $password,
            $this->hasher
        );
    }

    /**
     * @return string
     */
    public function toString()
    {
        return (string) $this->getPassword();
    }
}
