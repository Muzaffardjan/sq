<?php
/**
 * Sayyor qabul kunlari
 *
 * @author    Muzaffardjan Karaev
 * @copyright Copyright (c) "FOR EACH SOFT" LTD 2015 (http://www.each.uz)
 * @license   "FOR EACH SOFT" LTD PUBLIC LICENSE
 * Created:   10.03.2017
 */
namespace Users\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Element;

class LoginForm extends Form implements InputFilterProviderInterface
{
    public function __construct($name = 'login-form', array $options = [])
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
         * Remember me
         */
        $this->add(
            [
                'name' => 'rememberme',
                'type' => Element\Checkbox::class,
                'options' => [
                    'label' => 'Remember me',
                ],
                'attributes' => [
                    'required' => false,
                    'id' => 'inputCheckbox',
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
        return [
            'username' => [
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'min' => 5,
                            'max' => 36,
                        ],
                    ]
                ],
            ],
            'password' => [
                'required' => true,
            ],
            'rememberme' => [
                'required' => false,
            ],
            'csrf' => [
                'required' => true,
            ],
        ];
    }
}