<?php

namespace App\Controller\Admin;

use App\Entity\Tags;
use App\Entity\User;
use App\Entity\Animaux;
use App\Entity\Categorie;
use App\Entity\Commentaires;
use App\Repository\UserRepository;
use App\Repository\AnimauxRepository;
use App\Repository\CommentairesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    protected $animauxRepository;
    protected $userRepository;
    protected $commentairesRepository;
    // Insertion des repos
    public function __construct(
        AnimauxRepository $animauxRepository,
        UserRepository $userRepository,
        CommentairesRepository $commentairesRepository
    )
    {
        $this->animauxRepository = $animauxRepository;
        $this->userRepository = $userRepository;
        $this->commentairesRepository = $commentairesRepository;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('bundles/easyAdminBundle/welcome.html.Twig',[
            //Affichage de tout les animaux avec fonction countAllHelp
            'countAllAnimaux' => $this->animauxRepository->countAllHelp() ,
            'countAllUser' => $this->userRepository->countAllUser() ,
            'countAllComment' => $this->commentairesRepository->countAllComment() 
           
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Spa');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield   MenuItem::section('Animaux');
        yield   MenuItem::linkToCrud('Animal', 'fa fa-tags', Animaux::class);
        yield   MenuItem::linkToCrud('Categorie', 'fa fa-file-text', Categorie::class);
        yield   MenuItem::linkToCrud('Commentaires', 'fa fa-file-text', Commentaires::class);
        yield MenuItem::linkToCrud('Tags', 'fas fa-list', Tags::class);

        yield   MenuItem::section('Utilisateurs');
        yield   MenuItem::linkToCrud('Utilisateur', 'fa fa-tags', User::class);
        
    }
    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
        ->setName($user->getUsername())
        ->setGravatarEmail(($user->getUsername()))
        ->displayUserAvatar(true)
        ->setAvatarUrl("");
    }
}
