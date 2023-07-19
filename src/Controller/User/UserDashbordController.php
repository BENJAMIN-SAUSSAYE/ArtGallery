<?php

namespace App\Controller\User;

use App\Controller\User\AlbumCrudController;
use App\Controller\User\UserCrudController;
use App\Entity\Album;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class UserDashbordController extends AbstractDashboardController
{
    #[Route('/utilisateur/', name: 'gestion_user')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(AlbumCrudController::class)
            ->generateUrl());
    }

    #[Route('/utilisateur/profil/', name: 'gestion_user_profil')]
    public function profil(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)
            ->generateUrl());
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

        yield MenuItem::linkToUrl('Homepage', 'fa fa-house', $this->generateUrl('app_home_index'));

        yield MenuItem::linkToDashboard('Dashboard', 'fa-solid fa-gear');

        yield MenuItem::section('Gestion');
        yield MenuItem::linkToCrud('Albums', 'fas fa-list', Album::class)->setController('\App\Controller\User\AlbumCrudController')->setAction('index');
        yield MenuItem::linkToCrud('Images', 'fas fa-image', Album::class)->setController('\App\Controller\User\PictureCrudController')->setAction('index');

        yield MenuItem::section('Profil');
        yield MenuItem::linkToCrud('Voir', 'fa fa-eye', User::class)->setController('\App\Controller\User\UserCrudController')->setAction('index');
    }
}
