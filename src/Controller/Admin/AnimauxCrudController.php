<?php

namespace App\Controller\Admin;

use App\Entity\Animaux;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AnimauxCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Animaux::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        // $imageField = ImageField::new('imageFile')
        //   ->setFormType(VichImageType::class)
        //   ->setLabel('Image');

        // $image = ImageField::new('image')
        // ->setBasePath("/images/uploads")
        // ->setLabel('Image');

        return  [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
            IntegerField::new('age'),
            TextEditorField::new('description'),
            TextField::new('slug')->hideOnForm(),
            AssociationField::new('categorie'),
            TextField::new('race'),
            AssociationField::new('tag') ->autocomplete(),
            DateTimeField::new('created_at')->hideOnForm()->setlabel('Date d\'enregistrement')->setFormat('dd-MM-y HH:mm:ss'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyWhenCreating(),
            ImageField::new('image')->setBasePath('/images/uploads/')->onlyOnIndex(),
            SlugField::new('slug')->setTargetFieldName('nom')->onlyOnIndex()

        ];

         }
}
