<?php

namespace App\Controller\Admin;

use App\Entity\Commentaires;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommentairesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commentaires::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
           // IdField::new('id'),
           AssociationField::new('animal'),
           AssociationField::new('users'),
           DateTimeField::new('created_at'),
            TextareaField::new('contenu'),
            BooleanField::new('active'),
        ];
    }
    
}
