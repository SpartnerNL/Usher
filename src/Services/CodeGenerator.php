<?php namespace Maatwebsite\Usher\Services;

class CodeGenerator
{

    /**
     * @var string
     */
    private static $hashing = 'sha256';

    /**
     * @return string
     */
    public static function make()
    {
        return hash(static::$hashing, self::generateEntropy());
    }

    /**
     * @return string
     */
    public static function generateEntropy()
    {
        $entropy = mcrypt_create_iv(32, self::getRandomizer());
        $entropy .= uniqid(mt_rand(), true);

        return $entropy;
    }

    /**
     * @return int
     */
    protected static function getRandomizer()
    {
        if (defined('MCRYPT_DEV_URANDOM')) {
            return MCRYPT_DEV_URANDOM;
        }
        if (defined('MCRYPT_DEV_RANDOM')) {
            return MCRYPT_DEV_RANDOM;
        }
        mt_srand();

        return MCRYPT_RAND;
    }
}
