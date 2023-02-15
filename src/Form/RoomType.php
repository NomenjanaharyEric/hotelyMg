<?php

namespace App\Form;

use App\Entity\Room;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('number')
            ->add('name')
            ->add('size')
            ->add('location')
            ->add('capacity')
            ->add('price')
            ->add('description')
            ->add('hotel')
            ->add('submit', SubmitType::class, [
                "label" => "enregistrer",
                "attr" => ["class" => "btn btn-primary"]
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
