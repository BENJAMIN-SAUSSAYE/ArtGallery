<?php

namespace App\Twig\Components;

use App\Entity\Picture;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\Bundle\SecurityBundle\Security;

#[IsGranted('ROLE_USER')]
#[AsLiveComponent()]

class FavoritePictureComponent extends AbstractController
{
	use DefaultActionTrait;

	#[LiveProp]
	public bool $isLiked = false;

	#[LiveProp]
	public ?Picture $picture = null;

	public function __construct(private Security $security, private UserRepository $userRepository)
	{
	}

	#[LiveAction]
	public function updateState(): void
	{
		/** @var User $user */
		$user = $this->security->getUser();
		$this->isLiked = false;

		if (!$user->isInFavoritesPicture($this->picture)) {
			$user->addFavoritePicture($this->picture);
			$this->isLiked = true;
		} else {
			$user->removeFavoritePicture($this->picture);
		}
		$this->userRepository->save($user, true);
	}

	public function getState(): void
	{
		/** @var User $user */
		$user = $this->security->getUser();
		$this->isLiked =  $user->isInFavoritesPicture($this->picture);
	}
}
