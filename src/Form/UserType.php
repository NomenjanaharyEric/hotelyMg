<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                "label" => "Email",
                "label_attr" => ["class"=>"form-label"],
                "attr" => ["class" => "form-control"]
            ])
            ->add('fullname', TextType::class, [
                "label" => "Nom Complet",
                "label_attr" => ["class" => "form-label"],
                "attr" => ["class" => "form-control"]
            ])
            ->add('pseudo', TextType::class, [
                "label" => "Pseudo",
                "label_attr" => ["class" => "form-label"],
                "attr" => ["class" => "form-control"]
            ])
            ->add("submit", SubmitType::class, [
                "label" => "enregistrer",
                "attr" => ["class" => "btn btn-sm btn-primary"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
