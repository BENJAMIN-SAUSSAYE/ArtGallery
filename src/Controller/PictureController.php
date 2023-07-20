<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Form\PictureType;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function populairPictures(PictureRepository $pictureRepository): Response
    {
        $picturesLiked = $pictureRepository->getTopLikedPictures(self::NBR_LIKED_IMAGES);

        return $this->render('picture/liked_pictures.html.twig', [
            'pictures' => $picturesLiked,
        ]);
    }
}
