<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Twitter\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{

    /**
     * @param string $class The User class name
     */
   /*public function __construct($class)
    {
        $this->class = $class;
    }*/

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('email', 'email', array('label' => 'form.email', 'attr'=>array('placeholder'=>'Электронная почта'), 'translation_domain' => 'FOSUserBundle'))
            ->add('username', null, array('label' => 'form.username', 'attr'=>array('placeholder'=>'Имя пользователя'), 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password', 'attr'=>array('placeholder'=>'Пароль')),
                'second_options' => array('label' => 'form.password_confirmation', 'attr'=>array('placeholder'=>'Подтвердите пароль')),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
        ;
    }

    public function getName()
    {
        return 'twitter_user_registration';
    }
}
