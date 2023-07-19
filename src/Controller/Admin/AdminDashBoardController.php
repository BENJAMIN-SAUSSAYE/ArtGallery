<?php

namespace App\Controller\Admin;



use App\Controller\Admin\UserCrudController;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class AdminDashBoardController extends AbstractDashboardController
{
    #[Route('/administrateur', name: 'gestion_admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setFaviconPath('build/images/favicon.ico')
            ->setLocales(['fr' => '🇫🇷 Français', 'en' => '🇬🇧 English'])
            ->setTitle('')
            ->generateRelativeUrls();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Homepage', 'fas fa-home', $this->generateUrl('app_home_index'));

        yield MenuItem::section('Administrateur');

        yield MenuItem::linkToDashboard('Dashboard', 'fa-solid fa-gear');

        yield MenuItem::section('Users');
        yield MenuItem::linkToCrud('Ajouter', 'fa fa-circle-plus', User::class)->setController('\App\Controller\Admin\UserCrudController')->setAction('new');
        yield MenuItem::linkToCrud('Lister', 'fa fa-file-text', User::class)->setController('\App\Controller\Admin\UserCrudController')->setAction('index');
    }
}
