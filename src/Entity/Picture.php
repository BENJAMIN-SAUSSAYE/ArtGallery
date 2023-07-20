<?php

namespace App\Entity;

use App\Repository\PictureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\Authentication\Token\NullToken;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: PictureRepository::class)]
class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pictureFile = null;

    #[Vich\UploadableField(mapping: 'picture_file', fileNameProperty: 'pictureFile')]
    #[Assert\File(maxSize: '1M', mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],)]
    private ?File $file = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column]
    private ?bool $isPrivate = null;

    #[ORM\Column]
    private ?bool $isAlbumCover = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'], nullable: true)]
    private ?\DatetimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'pictures')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Album $album = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'likedPictures')]
    #[ORM\JoinTable(name: 'user_liked_picture')]
    private Collection $likedUsers;

    public function __construct(?bool $isPrivate = false)
    {
        $this->isPrivate = $isPrivate;
        $this->isAlbumCover = false;
        $this->createdAt = new \DateTime('now');
        $this->likedUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPictureFile(): ?string
    {
        return $this->pictureFile;
    }

    public function setPictureFile(?string $pictureFile): static
    {
        $this->pictureFile = $pictureFile;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreateAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isIsPrivate(): ?bool
    {
        return $this->isPrivate;
    }

    public function setIsPrivate(bool $isPrivate): static
    {
        $this->isPrivate = $isPrivate;

        return $this;
    }

    public function isIsAlbumCover(): ?bool
    {
        return $this->isAlbumCover;
    }

    public function setIsAlbumCover(bool $isAlbumCover): static
    {
        $this->isAlbumCover = $isAlbumCover;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(File $file = null): ?File
    {
        $this->file = $file;
        if ($file) {
            $this->updatedAt = new \DateTime('now');
        }
        return $this->file;
    }

    /**
     * Get the value of updatedAt
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): static
    {
        $this->album = $album;

        return $this;
    }

    public function __toString(): string
    {
        return (isset($this->title)) ? $this->title : '';
    }

    /**
     * @return Collection<int, User>
     */
    public function getLikedUsers(): Collection
    {
        return $this->likedUsers;
    }

    public function addLikedUser(User $likedUser): static
    {
        if (!$this->likedUsers->contains($likedUser)) {
            $this->likedUsers->add($likedUser);
            $likedUser->addLikedPicture($this);
        }

        return $this;
    }

    public function removeLikedUser(User $likedUser): static
    {
        if ($this->likedUsers->removeElement($likedUser)) {
            $likedUser->removeLikedPicture($this);
        }

        return $this;
    }
}
