<?php namespace Maatwebsite\Usher\Domain\Users\Activations;

use Doctrine\ORM\Mapping as ORM;
use Maatwebsite\Usher\Services\CodeGenerator;
use Maatwebsite\Usher\Domain\Shared\Embeddables\Date;
use Maatwebsite\Usher\Contracts\Users\Activiations\ActivationCode as ActivationCodeInterface;

/**
 * @ORM\Embeddable
 */
class ActivationCode extends Date implements ActivationCodeInterface
{

    /**
     * @ORM\Column(type="string", name="activation_code", unique=true)
     */
    protected $code;

    /**
     * @param string $code
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return ActivationCode
     */
    public static function generate()
    {
        return new static(
            CodeGenerator::make()
        );
    }

    /**
     * @return string
     */
    public function toString()
    {
        return (string) $this->getCode();
    }
}
