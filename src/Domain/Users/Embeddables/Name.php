<?php namespace Maatwebsite\Usher\Domain\Users\Embeddables;

use Assert\Assertion;
use Doctrine\ORM\Mapping as ORM;
use Maatwebsite\Usher\Domain\Shared\Embedabble;
use Maatwebsite\Usher\Contracts\Users\Embeddables\Name as NameInterface;

/**
 * @ORM\Embeddable
 */
class Name extends Embedabble implements NameInterface
{
    /**
     * @ORM\Column(type = "string")
     * @var string
     */
    protected $firstname;

    /**
     * @ORM\Column(type = "string")
     * @var string
     */
    protected $lastname;

    /**
     * @param string $firstname
     * @param string $lastname
     */
    public function __construct($firstname, $lastname)
    {
        $this->setFirstname($firstname);
        $this->setLastname($lastname);
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        Assertion::string($firstname);
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        Assertion::string($lastname);
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return (string) $this->getFirstname() . ' ' . $this->getLastname();
    }
}
