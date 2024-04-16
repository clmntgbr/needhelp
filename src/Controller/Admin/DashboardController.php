<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use App\Entity\Job;
use App\Entity\Jobber;
use App\Entity\Offer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('@EasyAdmin/page/content.html.twig');
    }

    public function configureCrud(): Crud
    {
        $crud = Crud::new();

        return $crud
            ->setDefaultSort(['updatedAt' => 'DESC']);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->generateRelativeUrls()
            ->setTitle('App');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToUrl('Api Docs', 'fas fa-map-marker-alt', '/api/docs');
        yield MenuItem::linkToCrud('Customer', 'fas fa-list', Customer::class);
        yield MenuItem::linkToCrud('Job', 'fas fa-list', Job::class);
        yield MenuItem::linkToCrud('Jobber', 'fas fa-list', Jobber::class);
        yield MenuItem::linkToCrud('Offer', 'fas fa-list', Offer::class);
    }
}
