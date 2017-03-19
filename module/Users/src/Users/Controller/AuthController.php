<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   09.03.2017
 */
namespace Users\Controller;

use Users\Adapter\AuthenticationAdapter;
use Users\Entity\User;
use Users\Service\AuthenticationService;
use Users\Service\UserService;
use Users\Storage\AuthenticationStorage;
use Users\ZfcRbac\Roles;
use Zend\Authentication\Result;
use Zend\Form\Form;
use Zend\Http\Request;
use Zend\Console\Request as ConsoleRequest;
use Zend\Mvc\Controller\AbstractActionController;

class AuthController extends AbstractActionController
{
    /**
     * @var Form
     */
    protected $form;

    /**
     * @var AuthenticationService
     */
    protected $authenticationService;

    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(
        AuthenticationService $authenticationService,
        UserService $userService,
        $form = null
    )
    {
        $this->setAuthenticationService($authenticationService);
        $this->setUserService($userService);
        $this->setForm($form);
    }

    /**
     * @return AuthenticationService
     */
    public function getAuthenticationService()
    {
        return $this->authenticationService;
    }

    /**
     * @param AuthenticationService $authenticationService
     * @return AuthController
     */
    public function setAuthenticationService($authenticationService)
    {
        $this->authenticationService = $authenticationService;
        return $this;
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
     * @return AuthController
     */
    public function setUserService($userService)
    {
        $this->userService = $userService;
        return $this;
    }

    /**
     * @return Form
     */
    public function getForm()
    {
        $form = $this->form->init();

        return $form;
    }

    /**
     * @param Form $form
     * @return AuthController
     */
    public function setForm($form)
    {
        $this->form = $form;
        return $this;
    }

    public function indexAction()
    {
        return [];
    }

    public function loginAction()
    {
        if ($this->identity()) {
            return $this->redirect()->toRoute(
                'app/home',
                ['locale' => $this->locale()->current()]
            );
        }

        $this->layout('users/layout/auth');

        /**
         * @var Request $request
         */
        $request = $this->getRequest();

        /**
         * @var Form $form
         */
        $form = $this->getForm();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();

                /**
                 * @var AuthenticationAdapter $authAdapter
                 */
                $authAdapter = $this->getAuthenticationService()->getAdapter();

                /**
                 * @var Result $result
                 */
                $result = $authAdapter->setIdentity($data['username'])
                    ->setCredential($data['password'])
                    ->authenticate();

                if ($result->isValid()) {
                    /**
                     * @var AuthenticationStorage $storage
                     */
                    $storage = $this->getAuthenticationService()->getStorage();

                    $storage->write($result->getIdentity());
                    $storage->setRememberMe(1);

                    return $this->redirect()->toRoute(
                        'app/home',
                        ['locale' => $this->locale()->current()]
                    );
                } else {
                    var_dump(
                        'User or password is wrong'
                    ); exit;
                }
            } else {
                var_dump(
                    'Form is not valid'
                ); exit;
            }
        }

        return [
            'form' => $form,
        ];
    }

    public function logoutAction()
    {
        /**
         * @var AuthenticationStorage $storage
         */
        $storage = $this->getAuthenticationService()->getStorage();

        $storage->forgetMe();
        $storage->clear();

        return $this->redirect()->toRoute(
            'app/home',
            ['locale' => $this->locale()->current()]
        );
    }

    public function registerAction()
    {
        if ($this->identity()) {
            return $this->redirect()->toRoute(
                'app/home',
                ['locale' => $this->locale()->current()]
            );
        }

        $this->layout('users/layout/auth');

        /**
         * @var Request $request
         */
        $request = $this->getRequest();

        /**
         * @var Form $form
         */
        $form = $this->getForm();

        if ($request->isPost()) {
            $post = $request->getPost();

            $birthday = \DateTime::createFromFormat('d/m/Y', $post['birthday']);

            $form->setData(
                [
                    'username'         => $post['username'],
                    'password'         => $post['password'],
                    'password_confirm' => $post['password_confirm'],
                    'email'            => $post['email'],
                    'first_name'       => $post['first_name'],
                    'last_name'        => $post['last_name'],
                    'birthday'         => $birthday,
                    'csrf'             => $post['csrf'],
                ]
            );

            if ($form->isValid()) {
                $data = $form->getData();

                $userService = $this->getUserService();
                $rdmString   = $userService->getRandomString();
                $hasher      = $userService->setUserSalt($rdmString)->getMkCrypt();
                $userEntity  = $userService->getUserEntity();

                $userEntity->setUsername($data['username'])
                    ->setPassword($hasher->create($data['password']))
                    ->setEmail($data['email'])
                    ->setFirstName($data['first_name'])
                    ->setLastName($data['last_name'])
                    ->setBirthday($birthday)
                    ->setRoles(Roles::DEFAULTUSER)
                    ->setSalt($rdmString);

                $userService->createUser($userEntity);

                return $this->redirect()->toRoute(
                    'app/home',
                    ['locale' => $this->locale()->current()]
                );
            } else {
                var_dump(
                    'Form is not valid',
                    $form->getMessages()
                ); exit;
            }
        }

        return [
            'form' => $form,
        ];
    }

    public function createSuperuserAction()
    {
        /**
         * @var Request
         */
        $request = $this->getRequest();

        if ($request instanceof ConsoleRequest) {
            /**
             * @var User $userEntity
             */
            $userEntity = $this->getUserService()->getUserEntity();

            $hasher = $this->getUserService()
                ->setUserSalt($this->getUserService()->getRandomString())
                ->getMkCrypt();

            $userEntity->setUsername($request->getParam('username'))
                ->setPassword($hasher->create($request->getParam('password')))
                ->setEmail($request->getParam('email'))
                ->setFirstName('')
                ->setLastName('')
                ->setBirthday(null)
                ->setRoles(Roles::SUPERUSER)
                ->setSalt($this->getUserService()->getUserSalt());

            $this->getUserService()->createUser($userEntity);
            return 'Done...';
        }

        $this->getResponse()->setStatusCode(404);
        return;
    }
}