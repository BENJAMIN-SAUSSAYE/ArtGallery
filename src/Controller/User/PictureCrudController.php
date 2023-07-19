<?php

namespace App\Controller\User;

use App\Entity\Picture;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PictureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Picture::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id')
            ->onlyOnIndex();

        yield TextField::new('firstName', 'Nom');

        yield TextField::new('lastName', 'Prénom');

        yield EmailField::new('email')
            ->hideWhenUpdating();
        //->onlyOnForms()->setFormTypeOption('disabled', true)->onlyWhenCreating()->setFormTypeOption('disabled', false)

        $roles = ['ROLE_ADMIN', 'ROLE_USER'];

        yield ArrayField::new('roles')->setFormTypeOption('disabled', true);

        yield DateTimeField::new('createdAt')
            ->hideOnForm()
            ->setFormTypeOption('disabled', 'disabled');
    }*/
}
