<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Entity\User;
use App\Form\PictureType;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/image')]
class PictureController extends AbstractController
{
    private const NBR_LIKED_IMAGES = 20;

    #[Route('/', name: 'app_picture_index', methods: ['GET'])]
    public function index(PictureRepository $pictureRepository): Response
    {
        return $this->render('picture/index.html.twig', [
            'pictures' => $pictureRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_picture_show', methods: ['GET'])]
    public function show(Picture $picture): Response
    {
        return $this->render('picture/show.html.twig', [
            'picture' => $picture,
        ]);
    }

    #[Route('/populaires/liste', name: 'app_picture_liked', methods: ['GET'])]
    public function likedPictures(PictureRepository $pictureRepository): Response
    {
        $picturesLiked = $pictureRepository->getTopLikedPictures(self::NBR_LIKED_IMAGES);

        return $this->render('picture/liked_pictures.html.twig', [
            'pictures' => $picturesLiked,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/favoris/liste', name: 'app_picture_favorite', methods: ['GET'])]
    public function favoritePictures(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('picture/liked_pictures.html.twig', [
            'pictures' => $user->getFavoritePictures(),
        ]);
    }
}
