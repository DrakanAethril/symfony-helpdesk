<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Ticket;
use App\Enum\Priorite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, ['label' => 'Titre'])
            ->add('description', TextareaType::class, [
                'help' => 'Que se passe-t-il ? Depuis quand ?',
            ])
            ->add('priorite', EnumType::class, [
                'class' => Priorite::class, 'label' => 'Priorité',
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class, 'label' => 'Catégorie',
                'choice_label' => 'nom',
                'placeholder' => 'Choisir une catégorie',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
