<?php

namespace App\Controller;

use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_home_')]
class HomeController extends AbstractController
{
	#[Route('/', name: 'index')]
	public function index(PictureRepository $pictureRepository): Response
	{
		$lastPictures = $pictureRepository->findLastPublicPostedImages(10);

		return $this->render('home/index.html.twig', [
			'lastPublicPostedPictures' => $lastPictures,
		]);
	}
}
