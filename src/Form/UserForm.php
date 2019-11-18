<?php
/**
 * Created by PhpStorm.
 * User: arisen
 * Date: 20.07.18
 * Time: 11:59
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('email', EmailType::class)
           ->add('plainPassword', RepeatedType::class, ['type' => PasswordType::class])
           ->add('roles', ChoiceType::class, [
               'multiple' => true,
               'expanded' => true,
               'choices' => [
                   'Doctor' => 'ROLE_DOCTOR',
                   'Researcher' => 'ROLE_RESEARCHER',
                   'Admin' => 'ROLE_ADMIN',
               ]
           ])
           ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => User::class]);
    }
}