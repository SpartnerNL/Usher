<?php namespace Maatwebsite\Usher\Domain\Users\Embeddables;

use Assert\Assertion;
use Doctrine\ORM\Mapping as ORM;
use Maatwebsite\Usher\Domain\Shared\Embedabble;
use Maatwebsite\Usher\Contracts\Users\Embeddables\Email as EmailInterface;

/**
 * @ORM\Embeddable
 */
class Email extends Embedabble implements EmailInterface
{
    /**
     * @ORM\Column(type = "string")
     */
    protected $email;

    /**
     * @param $email
     */
    public function __construct($email)
    {
        $this->setEmail($email);
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        Assertion::email($email);
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return (string) $this->getEmail();
    }
}
