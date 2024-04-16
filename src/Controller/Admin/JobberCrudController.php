<?php

namespace App\Controller\Admin;

use App\Entity\Jobber;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class JobberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Jobber::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled(),
            TextField::new('name'),
            TextField::new('email'),
            TextField::new('phone'),
            TextField::new('address'),
            DateTimeField::new('createdAt')->setFormat('dd/MM/Y HH:mm:ss')->renderAsNativeWidget()->setDisabled(),
            DateTimeField::new('updatedAt')->setFormat('dd/MM/Y HH:mm:ss')->renderAsNativeWidget()->setDisabled(),
            CollectionField::new('offers')->hideOnIndex(),
        ];
    }
}
