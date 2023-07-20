<?php

namespace App\Controller\User;

use App\Entity\Picture;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
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

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters)
            ->leftJoin('entity.album', 'album')
            ->andWhere('album.user = :user')
            ->setParameter('user', $this->getUser());
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the max number of entities to display per page
            ->setPaginatorPageSize(10)
            // the number of pages to display on each side of the current page
            // e.g. if num pages = 35, current page = 7 and you set ->setPaginatorRangeSize(4)
            // the paginator displays: [Previous]  1 ... 3  4  5  6  [7]  8  9  10  11 ... 35  [Next]
            // set this number to 0 to display a simple "< Previous | Next >" pager
            ->setPaginatorRangeSize(4)
            // these are advanced options related to Doctrine Pagination
            // (see https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/tutorials/pagination.html)
            ->setPaginatorUseOutputWalkers(true)
            ->setPaginatorFetchJoinCollection(true)
            // call this method to focus the search input automatically when loading the 'index' page
            ->setAutofocusSearch();
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
