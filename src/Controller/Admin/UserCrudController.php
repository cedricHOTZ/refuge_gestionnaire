<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\MessageService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class UserCrudController extends AbstractCrudController
{
    // Appel du service MessageService pour pouvoir l'utiliser
    protected $messageService;

    public function __construct(MessageService $messageService){
        $this->messageService = $messageService;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }
     
    //Affichage des massages flash

    // public function updateEntity(EntityManagerInterface $entityManagerInterface, $entityInstance): void{
    //     parent::updateEntity($entityManagerInterface, $entityInstance);
    //     $this->messageService->addSuccess('Votre modification a bien été enregistré');
    // }

    // public function deleteEntity(EntityManagerInterface $entityManagerInterface, $entityInstance): void{
    //     parent::deleteEntity($entityManagerInterface, $entityInstance);
    //     $this->messageService->addSuccess('Votre suppression a bien été enregistré');
    // }
    
    // public function createEntity(string $entityFqcn)
    //  {
    //      parent::createEntity($entityFqcn);
    //      $this->messageService->addSuccess('Votre ajout a bien été enregistré');
    //  }

    public function action(Request $request, MessageService $messageService)
    {
        $formContact = $this->createForm(ContactType::class,null);
        $formContact->handleRequest($request);
        if($formContact->isSubmitted() && $formContact->isValid() ){
            $data = $formContact->getData();
            if(true){
                $messageService->addSuccess('validation');
            }
            $messageService->addError('erreur');
        }
    }
    
  
    
    public function configureFields(string $pageName): iterable
    {
        return [
             IdField::new('id')->hideOnForm(),
             textfield::new('nom'),
             TextField::new('prenom'),
            TextField::new('email'),
            TextField::new('password'),
            ChoiceField::new('roles', 'Roles')
            ->allowMultipleChoices()
            ->autocomplete()
            ->setChoices([  'User' => 'ROLE_USER',
                            'Admin' => 'ROLE_ADMIN',
                            'SuperAdmin' => 'ROLE_SUPER_ADMIN']
                        )
        ];
        
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['id' => 'DESC']);
    }
    
    /**
     * @Route("/admin/user/statistic", name="statistic")
     * @param Request $request
     * @param UserRepository $userRepository
     * @return Response
     */
    public function statistic(Request $request, UserRepository $userRepository) {
        $id = $request->query->get('id');
        $user = $userRepository->find($id);

        $counterView = [];
        $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];

        foreach ($days as $day) {
            array_push($counterView, random_int(1, 10));
        }

        return $this->render('bundles/EasyAdminBundle/statistics_user.html.twig', [
            'user' => $user,
            'crudAction' => 'index',
            'counterView' => $counterView,
            'dataName' => $days
        ]);
    }
    public function configureFilters(Filters $filters):Filters
    {
        return $filters
        ->add('roles')
        ->add('id');
       
    }


    public function configureActions(Actions $actions): Actions
    {

           // Lien externe
           $linkExternes = Action::new('linkExterne', 'GitHub', 'fa fa-glob')
           ->linkToUrl("https://github.com")
           ->addCssClass('btn btn-primary')
           ->setHtmlAttributes([
               'target' => '_blank'
           ]);
        $removeUser = Action::new('removeUser', 'supprimer user','fa fa-trash');
     
       $statistic = Action::new('statistic','Stat User','fa fa-user')
       ->addCssClass('btn btn-primary')
       ->linkToRoute('statistic',function(UserInterface $entity){
           return[
               'id' => $entity->getId()
           ];
       });

        // style Boutton 
        return $actions
       // Desactive EDIT si le role est ROLE_USER 
      //  ->setPermission(Action::DELETE,'ROLE_USER')
      //  ->disable(Action::EDIT)

        //Ajoute la page DETAIL
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        
        //Ajoute le lien externe
        ->add(Crud::PAGE_INDEX, $linkExternes)
        
        // statistic
        // ->add(Crud::PAGE_INDEX,$statistic)

        //Modification des bouton
        ->update(Crud::PAGE_INDEX,Action::EDIT,function(Action $action){
            return $action->setIcon('fa fa-edit')->addCssClass('btn btn-danger');
        })
        ->update(Crud::PAGE_INDEX,Action::DETAIL,function(Action $action){
            return $action->setIcon('fa fa-eye')->addCssClass('btn btn-info');
        })
        ->update(Crud::PAGE_INDEX,Action::DELETE,function(Action $action){
            return $action->setIcon('fa fa-trash')->addCssClass('btn btn-outline-danger');
        });
    }
    
}
