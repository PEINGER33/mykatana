<?php

namespace App\Form;

use App\Entity\Katanakake;
use App\Entity\Katana;
use App\Repository\KatanaRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KatanakakeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //dump($options);
        // Get the current [object] from 'data' option passed to the form
        $katanakake = $options['data'] ?? null;
        // get the [galerie]'s creator
        $member = $katanakake->getCreateur();
        
        $builder
            ->add('description')
            ->add('publiee')
        
            ->add('createur', null, [
                'disabled' => true
            ])
            
            ->add('katanas', null, [
                // adjust the loading of possible [objects] to those of the current member's [inventory]
                // the use helps pass the member to the lambda
                'query_builder' => function (KatanaRepository $er) use ($member) {
                return $er->createQueryBuilder('o')
                ->leftJoin('o.trousseau', 'i')
                ->leftJoin('i.member', 'm')
                ->andWhere('m.id = :memberId')
                ->setParameter('memberId', $member->getId())
                ;
                }
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Katanakake::class,
        ]);
    }
}
