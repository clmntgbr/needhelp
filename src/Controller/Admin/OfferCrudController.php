<?php

namespace App\Controller\Admin;

use App\Entity\Offer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class OfferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Offer::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled(),
            NumberField::new('price'),
            ChoiceField::new('status')
                ->autocomplete()
                ->renderAsNativeWidget()
                ->setChoices([Offer::ACCEPTED => Offer::ACCEPTED, Offer::DENIED => Offer::DENIED]),
            AssociationField::new('jobber'),
            AssociationField::new('job'),
            DateTimeField::new('createdAt')->setFormat('dd/MM/Y HH:mm:ss')->renderAsNativeWidget()->setDisabled(),
            DateTimeField::new('updatedAt')->setFormat('dd/MM/Y HH:mm:ss')->renderAsNativeWidget()->setDisabled(),
        ];
    }
}
