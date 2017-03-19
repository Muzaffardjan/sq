<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   14.03.2017
 */
namespace Users\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Element;

class CreateUserForm extends Form implements InputFilterProviderInterface
{
    public function __construct($name = 'create-user-form', array $options = [])
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
                        'class' => 'control-label',
                    ],
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'id' => 'inputRounded',
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
                        'class' => 'control-label',
                    ],
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'id' => 'inputRounded',
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
                        'class' => 'control-label',
                    ],
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'id' => 'inputRounded',
                ],
            ]
        );

        /**
         * Roles
         */
        $this->add(
            [
                'name' => 'roles',
                'type' => Element\Select::class,
                'options' => [
                    'label' => 'Role',
                    'label_attributes' => [
                        'class' => 'control-label',
                    ],
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'id' => 'inputRounded',
                    'data-plugin' => 'selectpicker',
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
                        'class' => 'control-label',
                    ],
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'id' => 'inputRounded',
                ],
            ]
        );

        /**
         * Last name
         */
        $this->add(
            [
                'name' => 'last_name',
                'type' => Element\Text::class,
                'options' => [
                    'label' => 'Last name',
                    'label_attributes' => [
                        'class' => 'control-label',
                    ],
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'id' => 'inputRounded',
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
                        'class' => 'control-label',
                    ],
                    'format' => 'd/m/Y',
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'id' => 'inputRounded',
                    'data-plugin' => 'datepicker',
                ],
            ]
        );


        return $this;
    }

    public function getInputFilterSpecification()
    {
        return [];
    }
}