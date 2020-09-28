<?php

namespace App\Form;

use App\Entity\Incl;
use App\Form\ImclType;
use App\Form\ImageType;
use App\Entity\Activity;
use App\Entity\Requ;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ActivityType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre", "titre de l'activitee"))
            ->add('category', TextType::class, $this->getConfiguration("Categorie", "Montagne, Ocean, Ville, Nature, .."))
            ->add('description', TextType::class, $this->getConfiguration("Description", "Rapide descrition de l'activitee"))
            ->add('price', MoneyType::class, $this->getConfiguration("Prix", "Prix de l'activite par personne"))
            ->add('coverImage', UrlType::class, $this->getConfiguration("Image", "Url de l'image de couverture"))
            ->add('content', TextareaType::class, $this->getConfiguration("contenu", "contenu detaille de l'activitee"))
            ->add('images', CollectionType::class, ['entry_type' => ImageType::class, 'allow_add' => true, 'allow_delete' => true])
            //->add('incls', CollectionType::class, ['entry_type' => ImclType::class, 'allow_add' => true, 'allow_delete' => true])
            //->add('requs', CollectionType::class, ['entry_type' => RequType::class, 'allow_add' => true, 'allow_delete' => true]);
            ->add('incls', EntityType::class, ['label' => "A inclure", 'class' => Incl::class, 'choice_label' => 'title', 'multiple' => true, 'expanded' => true])
            ->add('requs', EntityType::class, ['label' => "Requis", 'class' => Requ::class, 'choice_label' => 'title', 'multiple' => true, 'expanded' => true]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
