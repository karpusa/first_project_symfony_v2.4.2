<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Twitter\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;

class TweetFormType extends BaseType
{
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Twitter\MainBundle\Entity\Tweet',
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', 'textarea', array('label' => 'Написать', 'attr'=>array('placeholder'=>'Ваш твит'), 'max_length' => 140))
            ->add('save', 'submit', array('label'=>'Отправить'));
    }

    public function getName()
    {
        return 'tweetform';
    }
}
