<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   09.03.2017
 */
namespace Users\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Users\Crypt\Password\MkCrypt;
use Users\Entity\User;
use Users\ZfcRbac\Roles;

class UserService
{
    const MCRYPT_COST = '12';

    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var User
     */
    protected $userEntity;

    /**
     * @var string
     */
    protected $userSalt;

    public function __construct(ObjectManager $objectManager)
    {
        $this->setObjectManager($objectManager);
        $this->setRepository($objectManager->getRepository(User::class));
        $this->setUserEntity(new User());
    }

    /**
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     * @param ObjectManager $objectManager
     * @return UserService
     */
    public function setObjectManager($objectManager)
    {
        $this->objectManager = $objectManager;
        return $this;
    }

    /**
     * @return ObjectRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param ObjectRepository $repository
     * @return UserService
     */
    public function setRepository(ObjectRepository $repository)
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserSalt()
    {
        return $this->userSalt;
    }

    /**
     * @param string $userSalt
     * @return UserService
     */
    public function setUserSalt($userSalt)
    {
        $this->userSalt = $userSalt;
        return $this;
    }

    /**
     * @return User
     */
    public function getUserEntity()
    {
        return $this->userEntity;
    }

    /**
     * @param User $userEntity
     * @return UserService
     */
    public function setUserEntity($userEntity)
    {
        $this->userEntity = $userEntity;
        return $this;
    }

    public function getMkCrypt()
    {
        return new MkCrypt(
            [
                'cost' => self::MCRYPT_COST,
                'salt' => $this->getUserSalt(),
            ]
        );
    }

    public function getRandomString($length = 16)
    {
        $length     = (int) $length;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string     = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $string;
    }

    public function createUser($entity)
    {
        $this->getObjectManager()->persist($entity);
        $this->getObjectManager()->flush();
    }

    public function update()
    {
        $this->getObjectManager()->flush();
    }

    public function getById($id)
    {
        return $this->getRepository()->find($id);
    }

    public function getUser($query)
    {
        return current($this->getRepository()->findBy($query));
    }

    public function isCredentialsValid($userPassword, $password)
    {
        return $this->getMkCrypt()->verify($userPassword, $password);
    }

    public function getAllUser()
    {
        $u = $this->getRepository()->findAll();

        $users = [];
        foreach ($u as $key => $value) {
            if ($value->getRoles() == Roles::SUPERUSER) {
                continue;
            } else {
                $users[] = $value;
            }
        }

        return $users;
    }
}