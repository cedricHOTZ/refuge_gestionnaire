<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Commentaires;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\User as users;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentaireType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
        
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $user = $this->security->getUser();
        // dd($user->getEmail());
         $builder
            // ->add('email', EmailType::class)

           
            ->add('contenu',TextareaType::class)
           ->add('Soumettre',SubmitType::class)
           
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaires::class,
        ]);
    }
}
