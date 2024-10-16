<?php

namespace App\Controller\Admin;

use App\Entity\Bonbon;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BonbonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bonbon::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            TextField::new('gout'),
            TextField::new('ingredients'),
            NumberField::new('prix')->setNumDecimals(2),
            ImageField::new('image')->setBasePath('assets/images/')->setUploadDir('public/assets/images/')->setRequired(false),
            NumberField::new('poids')
        ];
    }
}
