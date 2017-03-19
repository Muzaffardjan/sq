<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   11.03.2017
 */
namespace Users\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Element;

class RegisterForm extends Form implements InputFilterProviderInterface
{
    public function __construct($name = 'register-form', array $options = [])
    {
        parent::__construct($name, $options);
    }

    public function init()
    {
        $this->setAttribute('method', 'post');

        /**
         * Username
         */
        $this->add(
            [
                'name' => 'username',
                'type' => Element\Text::class,
                'options' => [
                    'label' => 'Username',
                    'label_attributes' => [
                        'class' => 'floating-label',
                    ],
                ],
                'attributes' => [
                    'required' => true,
                    'class' => 'form-control',
                ],
            ]
        );

        /**
         * Password
         */
        $this->add(
            [
                'name' => 'password',
                'type' => Element\Password::class,
                'options' => [
                    'label' => 'Password',
                    'label_attributes' => [
                        'class' => 'floating-label',
                    ],
                ],
                'attributes' => [
                    'required' => true,
                    'class' => 'form-control',
                ],
            ]
        );

        /**
         * Password confirm
         */
        $this->add(
            [
                'name' => 'password_confirm',
                'type' => Element\Password::class,
                'options' => [
                    'label' => 'Password confirm',
                    'label_attributes' => [
                        'class' => 'floating-label',
                    ],
                ],
                'attributes' => [
                    'required' => true,
                    'class' => 'form-control',
                ],
            ]
        );

        /**
         * Email
         */
        $this->add(
            [
                'name' => 'email',
                'type' => Element\Email::class,
                'options' => [
                    'label' => 'Email',
                    'label_attributes' => [
                        'class' => 'floating-label',
                    ],
                ],
                'attributes' => [
                    'required' => true,
                    'class' => 'form-control',
                ],
            ]
        );

        /**
         * First name
         */
        $this->add(
            [
                'name' => 'first_name',
                'type' => Element\Text::class,
                'options' => [
                    'label' => 'First name',
                    'label_attributes' => [
                        'class' => 'floating-label',
                    ],
                ],
                'attributes' => [
                    'required' => true,
                    'class' => 'form-control',
                ],
            ]
        );

        /**
         * Second name
         */
        $this->add(
            [
                'name' => 'last_name',
                'type' => Element\Text::class,
                'options' => [
                    'label' => 'Last name',
                    'label_attributes' => [
                        'class' => 'floating-label',
                    ],
                ],
                'attributes' => [
                    'required' => true,
                    'class' => 'form-control',
                ],
            ]
        );

        /**
         * Birthday
         */
        $this->add(
            [
                'name' => 'birthday',
                'type' => Element\DateTime::class,
                'options' => [
                    'label' => 'Birthday',
                    'label_attributes' => [
                        'class' => 'floating-label',
                    ],
                    'format' => 'd/m/Y',
                ],
                'attributes' => [
                    'required' => true,
                    'class' => 'form-control',
                    'data-plugin' => 'datepicker',
                ],
            ]
        );

        /**
         * Csrf
         */
        $this->add(
            [
                'name' => 'csrf',
                'type' => Element\Csrf::class,
            ]
        );

        return $this;
    }

    public function getInputFilterSpecification()
    {
        return [];
    }
}