<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   09.03.2017
 */
namespace Users\Adapter;

use Users\Service\UserService;
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result;

class AuthenticationAdapter extends AbstractAdapter
{
    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->setUserService($userService);
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
     * @return AuthenticationAdapter
     */
    public function setUserService(UserService $userService)
    {
        $this->userService = $userService;
        return $this;
    }

    public function authenticate()
    {
        if (!$this->getIdentity() || !$this->getCredential()) {
            throw new \Exception('Username or password not provided');
        }


        $userService = $this->getUserService();
        $user = $userService->getUser(['username' => $this->getIdentity()]);

        $userService->setUserSalt($user->getSalt());

        if (!$user) {
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, $user);
        } else {
            if (
                !$userService->isCredentialsValid(
                    $this->getCredential(),
                    $user->getPassword()
                )
            ) {
                return new Result(Result::FAILURE_UNCATEGORIZED, null);
            } else {
                return new Result(Result::SUCCESS, $user);
            }
        }
    }
}