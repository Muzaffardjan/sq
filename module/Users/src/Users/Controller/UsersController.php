<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   13.03.2017
 */
namespace Users\Controller;

use Admin\Controller\AbstractAdminController;
use Users\Entity\User;
use Users\Service\UserService;
use Users\ZfcRbac\Roles;
use Zend\Form\Form;

class UsersController extends AbstractAdminController
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var Form
     */
    protected $form;

    public function __construct(UserService $userService, $form)
    {
        $this->setUserService($userService);
        $this->form = $form;
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
     * @return UsersController
     */
    public function setUserService($userService)
    {
        $this->userService = $userService;
        return $this;
    }

    public function indexAction()
    {
        $users = $this->getUserService()->getAllUser();

        return [
            'users' => $users,
        ];
    }

    public function createAction()
    {
        /**
         * @var Form $form
         */
        $form = $this->form->init();

        /**
         * @var \Zend\Http\Request $request
         */
        $request = $this->getRequest();

        /**
         * @var UserService $userService
         */
        $userService = $this->getUserService();

        $form->get('roles')->setValueOptions(
            [
                Roles::DEFAULTUSER => 'Simple user',
                Roles::MODERUSER   => 'Moderator',
                Roles::ADMINUSER   => 'Administrator',
            ]
        );

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data   = $form->getData();
                $hash   = $userService->getRandomString();
                $hasher = $userService->setUserSalt($hash)->getMkCrypt();

                /**
                 * @var User $userEntity
                 */
                $userEntity = $userService->getUserEntity();

                var_dump(
                    1
                ); exit;

                $date = \DateTime::createFromFormat('d.m.Y', $data['birthday']);

                $userEntity->setUsername($data['username'])
                    ->setPassword($hasher->create($data['password']))
                    ->setEmail($data['email'])
                    ->setRoles($data['roles'])
                    ->setFirstName($data['first_name'])
                    ->setLastName($data['last_name'])
                    ->setBirthday($date)
                    ->setSalt($hash);

                $userService->createUser($userEntity);

                return $this->redirect()->toRoute(
                    'app/admin/users',
                    ['locale' => $this->locale()->current()]
                );
            } else {
                var_dump(
                    $form->getMessages()
                ); exit;
            }
        }

        return [
            'form' => $form,
        ];
    }

    public function editAction()
    {
        /**
         * @var Form $form
         */
        $form = $this->form->init();

        /**
         * @var \Zend\Http\Request $request
         */
        $request = $this->getRequest();

        /**
         * @var UserService $userService
         */
        $userService = $this->getUserService();

        $form->get('roles')->setValueOptions(
            [
                Roles::DEFAULTUSER => 'Simple user',
                Roles::MODERUSER   => 'Moderator',
                Roles::ADMINUSER   => 'Administrator',
            ]
        );

        $user = $userService->getById($this->params('id'));

        if ($request->isPost()) {
            $post = $request->getPost();

            $birthday = \DateTime::createFromFormat('d/m/Y', $post['birthday']);

            $form->setData(
                [
                    'username'   => $post['username'],
                    'password'   => $post['password'],
                    'email'      => $post['email'],
                    'roles'      => $post['roles'],
                    'first_name' => $post['first_name'],
                    'last_name'  => $post['last_name'],
                    'birthday'   => $birthday,
                ]
            );

            if ($form->isValid()) {
                $data   = $form->getData();
                $hash   = $user->getSalt();
                $hasher = $userService->setUserSalt($hash)->getMkCrypt();

                $user->setUsername($data['username'])
                    ->setPassword($hasher->create($data['password']))
                    ->setEmail($data['email'])
                    ->setFirstName($data['first_name'])
                    ->setLastName($data['last_name'])
                    ->setBirthday($data['birthday'])
                    ->setRoles($data['roles']);

                $userService->update();

                return $this->redirect()->toRoute(
                    'app/admin/users',
                    ['locale' => $this->locale()->current()]
                );
            }
        } else {
            $form->setData(
                [
                    'username'   => $user->getUsername(),
                    'password'   => $user->getPassword(),
                    'email'      => $user->getEmail(),
                    'roles'      => $user->getRoles(),
                    'first_name' => $user->getFirstName(),
                    'last_name'  => $user->getLastName(),
                    'birthday'   => $user->getBirthday(),
                ]
            );
        }

        return [
            'form' => $form,
            'user' => $user,
        ];
    }
}