<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class UserType extends AbstractType
{

    private $authorization;

    public function __construct(AuthorizationChecker $authorizationChecker)
    {
        $this->authorization = $authorizationChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if ($this->authorization->isGranted('ROLE_SUPER_ADMIN')) {
            $builder
                ->add('username')
                ->add('roles', ChoiceType::class, [
                    'multiple' => true,
                    'expanded' => true, // render check-boxes
                    'choices' => [
                        'SuperAdmin' => 'ROLE_SUPER_ADMIN',
                        'Admin' => 'ROLE_ADMIN',
                        'User' => 'ROLE_USER',
                        // ...
                    ],
                ])
                ->add('imageFile', FileType::class, [
                    'required' => false
                ]);

        } elseif ($this->authorization->isGranted('ROLE_ADMIN')) {
            $builder
                ->add('username')
                ->add('imageFile', FileType::class, [
                    'required' => false
                ]);
        } else {
            $builder
                ->add('imageFile', FileType::class, [
                    'required' => false
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'forms'
        ]);
    }
}
