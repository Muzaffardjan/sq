<?php
/**
 * My comp files
 *
 * @author    Muzaffardjan Karaev
 * @copyright (c) Copyright "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   06.03.2017
 */
namespace Users\Crypt\Password;

use Traversable;
use Zend\Crypt\Password\PasswordInterface;
use Zend\Stdlib\ArrayUtils;
use Zend\Math\Rand;

class MkCrypt implements PasswordInterface
{
    const MIN_SALT_SIZE = 16;

    /**
     * @var string
     */
    protected $cost = '10';

    /**
     * @var string
     */
    protected $salt;

    public function __construct(array $options = [])
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        } elseif (!is_array($options)) {
            throw new Exception\InvalidArgumentException(
                'The options parameter must be an array or a Traversable'
            );
        }

        foreach ($options as $key => $value) {
            switch (strtolower($key)) {
                case 'salt':
                    $this->setSalt($value);
                    break;
                case 'cost':
                    $this->setCost($value);
                    break;
            }
        }
    }

    public function create($password)
    {
        if (empty($this->getSalt())) {
            $salt = Rand::getBytes(self::MIN_SALT_SIZE);
        } else {
            $salt = $this->getSalt();
        }

        $salt64  = substr(str_replace('+', '.', base64_encode($salt)), 0, 22);
        $options = [
            'cost' => $this->getCost(),
            'salt' => $salt64,
        ];

        $hash = password_hash($password, PASSWORD_BCRYPT, $options);

        if (strlen($hash) < 13) {
            throw new Exception\RuntimeException(
                'Error during the bcrypt generation'
            );
        }

        return $hash;
    }

    public function verify($password, $hash)
    {
        $password = (string) $password;
        $hash     = (string) $hash;

        if (function_exists('password_verify')) {
            return password_verify($password, $hash);
        }

        $lengthPassword = strlen($password);
        $lengthHash     = strlen($hash);
        $minLength      = min($lengthHash, $lengthPassword);
        $result         = 0;

        for ($i = 0; $i < $minLength; $i++) {
            $result |= ord($password[$i]) ^ ord($hash[$i]);
        }

        $result |= $lengthPassword ^ $lengthHash;

        return ($result === 0);
    }

    /**
     * @return string
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param string $cost
     * @return MkCrypt
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
        return $this;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     * @return MkCrypt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
        return $this;
    }
}