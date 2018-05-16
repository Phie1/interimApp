<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 14/05/2018
 * Time: 10:06
 */

namespace App\Form;


use App\Entity\Interim;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterimType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('surname', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('mail', EmailType::class, array(
                'label' => 'Adresse mail',
            ))
            ->add('zipCode', TextType::class, array(
                'label' => 'Code postal',
                'attr' => array('maxlength' => 5),
            ))
            ->add('city', TextType::class, array(
                'label' => 'Ville',
                'required' => false
            ))
            ->add('save', SubmitType::class, array(
                    'label' => 'Valider')
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Interim::class,
        ));
    }
}