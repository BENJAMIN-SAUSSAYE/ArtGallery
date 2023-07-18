<?php

namespace App\Entity;

use App\Repository\PictureRepository;
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

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255)]
    private ?string $pictureFile = null;

    #[Assert\Image]
    #[Vich\UploadableField(mapping: 'picture_file', fileNameProperty: 'pictureFile')]
    #[Assert\File(
        maxSize: '1M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $file = null;

    #[Assert\DateTime]
    #[ORM\Column]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column]
    private ?bool $isPrivate = null;

    #[ORM\Column]
    private ?bool $isAlbumCover = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DatetimeInterface $updatedAt = null;

    public function __construct(?bool $isPrivate = false)
    {
        $this->isPrivate = $isPrivate;
        $this->isAlbumCover = false;
        $this->createdAt = new \DateTime('now');
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

    public function setPictureFile(string $pictureFile): static
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

    public function setFile(File $file = null): File
    {
        $this->file = $file;
        if ($file) {
            $this->updatedAt = new \DateTime('now');
        }
        return $this->file;
    }
}
