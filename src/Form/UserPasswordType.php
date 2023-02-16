<?php 

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class UserPasswordType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plainPassword', PasswordType::class, [
                "label" => "Ancien Mot de passe",
                "label_attr" => ["class" => "form-label"],
                "attr" => ["class" => "form-control"]
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => ['attr' => ['class' => 'form-control']],
                'required' => true,
                'first_options' => ['label' => 'Nouveau Mot de passe'],
                'second_options' => ['label' => 'Confirmer Nouveau Mot de passe'],
                'invalid_message' => "Veuillez repeter votre nouveau mot de passe"
            ])
            ->add("submit", SubmitType::class, [
                "label" => "enregistrer",
                "attr" => ["class" => "btn btn-sm btn-primary"]
            ]);
    }

}