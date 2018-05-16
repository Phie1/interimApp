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
use App\Entity\Mission;
use App\Enum\MissionStatusEnum;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('interim', EntityType::class, [
                'class' => Interim::class,
                'label' => 'Intérimaire'
            ])
            ->add('contract', EntityType::class, [
                'class' => Contract::class,
                'label' => 'Contrat'
            ])
            ->add('rating', ChoiceType::class, array(
                'label' => 'Note',
                'choices' => range(1,10),
                'choice_label' => function ($value) {
                    return $value;
                },
            ))
            ->add('status', ChoiceType::class, array(
                'label' => 'Statut',
                'choices' => MissionStatusEnum::getAvailableStatus(),
                'choice_label' => function($choice) {
                    return MissionStatusEnum::getStatusName($choice);
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
            'data_class' => Mission::class,
        ));
    }
}