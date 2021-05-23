<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Commentaires;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Validator\Constraints\DateTime as date;
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
           AssociationField::new('user')->hideOnForm(),
           DateTimeField::new('created_at')->hideOnForm()->setlabel('Date d\'enregistrement')->setFormat('dd-MM-y HH:mm:ss'),
            TextareaField::new('contenu'),
            BooleanField::new('active'),
        ];
    }
    public function configureFilters(Filters $filters):Filters
    {
        return $filters
        ->add('animal')
        ->add('contenu')
        ->add('user');
       
       
    }
    
}
