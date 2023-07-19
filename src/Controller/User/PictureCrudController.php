<?php

namespace App\Controller\User;

use App\Entity\Picture;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PictureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Picture::class;
    }

    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id')
            ->onlyOnIndex();

        yield TextField::new('title', 'Titre');

        yield ImageField::new('pictureFile', 'Image')
            ->setBasePath($this->getParameter("upload_uriprefix"))
            ->setUploadDir($this->getParameter("upload_directory"))->onlyOnIndex();

        yield TextField::new('file', 'Image')
            ->setFormType(VichImageType::class)
            ->hideOnIndex();

        yield DateTimeField::new('createdAt')
            ->hideOnForm()
            ->setFormTypeOption('disabled', 'disabled');

        yield AssociationField::new('album')->setLabel('Album')->setQueryBuilder(function (QueryBuilder $queryBuilder) {
            $queryBuilder->where('entity.user  = :user')
                ->setParameter('user', $this->getUser());
        });

        //->setFormTypeOption('disabled', 'disabled');

        yield BooleanField::new('isPrivate', 'Album Privé')
            ->renderAsSwitch();

        yield BooleanField::new('isAlbumCover', 'Couverture de l\'album')
            ->renderAsSwitch();
    }
}
