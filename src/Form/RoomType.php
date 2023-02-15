<?php

namespace App\Form;

use App\Entity\Hotel;
use App\Entity\Room;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RoomType extends AbstractType
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
            ->add('number', IntegerType::class, [
                "label" => "Numero",
                "label_attr" => ["class" => "form-label"],
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('name', TextType::class, [
                "label" => "Nom",
                "label_attr" => ["class" => "form-label"],
                "attr" => ["class" => "form-control"]
            ])
            ->add('size', IntegerType::class, [
                "label" => "Surface en m²",
                "label_attr" => ["class" => "form-label"],
                "attr" => ["class" => "form-control"]
            ])
            ->add('location', TextType::class, [
                "label" => "Location",
                "label_attr" => ["class" => "form-label"],
                "attr" => ["class" => "form-control"]
            ])
            ->add('capacity', IntegerType::class, [
                "label" => "Capacité",
                "label_attr" => ["class" => "form-label"],
                "attr" => ["class" => "form-control"]
            ])
            ->add('price', MoneyType::class, [
                "label" => "Prix",
                "currency" => "MGA",
                "label_attr" => ["class" => "form-label"],
                "attr" => ["form-control"]
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description",
                "label_attr" => ["class" => "form-label"],
                "attr" => [
                    "class" => "form-control",
                    "placeholder" => "Description de la chambre"
                ]
            ])
            ->add('hotel', EntityType::class, [
                "class" => Hotel::class,
                "label" => "Hotel",
                "label_attr" => ["class" => "form-label"],
                "attr" => ["class" => "form-control"]
            ])
            ->add('submit', SubmitType::class, [
                "label" => "enregistrer",
                "attr" => ["class" => "btn btn-sm btn-primary"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}
