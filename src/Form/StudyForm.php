<?php
/**
 * Created by PhpStorm.
 * User: arisen
 * Date: 09.07.18
 * Time: 16:44
 */

namespace App\Form;

use App\Entity\Study;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudyForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', null, ['attr' => ['autofocus' => true]])
            ->add('title', null)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Study::class]);
    }
}