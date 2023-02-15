<?php

namespace App\Form;

use App\Entity\Hotel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class HotelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                "label" => "Photo",
                "label_attr" => ["class" => "form-label"],
                "attr" => ["class" => "form-control" ],
                "required" => false
            ])
            ->add('name', TextType::class, [
                "label" => "Nom",
                "label_attr" => ["class" => "form-label"],
                "attr" => [
                    "class" => "form-control",
                    "minlength" => '3',
                    "maxlength" => '100'
                ],
            ])
            ->add('adress', TextType::class, [
                "label" => "Adresse",
                "label_attr" => ["class" => "form-label"],
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('nbStar', RangeType::class, [
                "label" => "Nombre d'etoiles",
                "label_attr" => ["class" => "form-label"],
                "attr" => ['min' => 0, 'max' => 5]
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description",
                "label_attr" => ["class" => "form-label"],
                "attr" => [
                    "class" => "form-control",
                    "placeholder" => "Décrivez votre hotel"
                ]
            ])
            ->add('submit', SubmitType::class, [
                "label" => "enregistrer",
                "attr" => ["class" => "btn btn-primary"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hotel::class,
        ]);
    }
}
