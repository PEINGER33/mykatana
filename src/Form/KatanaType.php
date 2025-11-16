<?php

namespace App\Form;

use App\Entity\Katana;
use App\Entity\Katanakake;
use App\Entity\Trousseau;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KatanaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('type')
            ->add('longueur')
            ->add('trousseau', EntityType::class, [
                'class' => Trousseau::class,
                'choice_label' => 'id',
            ])
            ->add('katanakakes', EntityType::class, [
                'class' => Katanakake::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Katana::class,
        ]);
    }
}
