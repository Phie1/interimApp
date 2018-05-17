<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 14/05/2018
 * Time: 10:06
 */

namespace App\Form;


use App\Entity\Contract;
use App\Entity\Interim;
use App\Enum\ContractStatusEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('interim', EntityType::class, [
                'class' => Interim::class,
                'label' => 'Intérimaire'
            ])*/
            ->add('interim', TextType::class, [
                'label' => 'Intérimaire'
            ])
            ->add('dateStart', DateType::class, array(
                'label' => 'Date de début',
                'format' => 'dd - MMMM - yyyy'
            ))
            ->add('dateEnd', DateType::class, array(
                'label' => 'Date de fin',
                'format' => 'dd - MMMM - yyyy'
            ))
            ->add('status', ChoiceType::class, array(
                'label' => 'Statut',
                'choices' => ContractStatusEnum::getAvailableStatus(),
                'choice_label' => function($choice) {
                    return ContractStatusEnum::getStatusName($choice);
                },
            ))
            ->add('save', SubmitType::class, array(
                    'label' => 'Valider')
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Contract::class,
        ));
    }
}