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

class SearchFormType extends BaseType
{
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Twitter\MainBundle\Entity\Search',
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Кого ищем?', 'attr'=>array('placeholder'=>'Пользователь')))
            ->add('search', 'submit', array('label'=>'Поиск'));
    }    

    public function getName()
    {
        return 'searchform';
    }
}
