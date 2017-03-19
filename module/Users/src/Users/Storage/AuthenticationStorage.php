<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   09.03.2017
 */
namespace Users\Storage;

use Users\Service\UserService;
use Zend\Authentication\Storage\Session;
use Zend\Session\Container;

/**
 * Class AuthenticationStorage
 * @package Users\Storage
 */
class AuthenticationStorage extends Session
{
    const STORAGE_NAME = 'ForeachSoft';

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var Container
     */
    protected $session;

    public function __construct(UserService $userService)
    {
        parent::__construct(self::STORAGE_NAME);

        $this->setUserService($userService);
        $this->setSession(new Container(self::STORAGE_NAME));
    }

    /**
     * @return UserService
     */
    public function getUserService()
    {
        return $this->userService;
    }

    /**
     * @param UserService $userService
     * @return AuthenticationStorage
     */
    public function setUserService($userService)
    {
        $this->userService = $userService;
        return $this;
    }

    /**
     * @return Container
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param Container $session
     * @return AuthenticationStorage
     */
    public function setSession($session)
    {
        $this->session = $session;
        return $this;
    }

    public function read()
    {
        if (parent::isEmpty()) {
            return false;
        }

        return $this->getUserService()->getById((int) parent::read());
    }

    public function write($contents)
    {
        if ($contents) {
            parent::write($contents->getId());
        } else {
            throw new \Exception("You must login");
        }
    }

    public function setRememberMe($time = 0)
    {
        $time = (int) $time * 86400;

        if ($time > 0) {
            $this->getSession()->getManager()->rememberMe($time);
        }
    }

    public function forgetMe()
    {
        $this->getSession()->getManager()->forgetMe();
    }
}