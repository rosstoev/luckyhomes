<?php
declare(strict_types=1);

namespace App\Controller\Admin;


use App\Entity\Apartment;
use App\Repository\ApartmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/luxadmin", name="admin_home")
     * @param ApartmentRepository $apartmentRepo
     * @return Response
     */
    public function home(ApartmentRepository $apartmentRepo)
    {
        /** @var Apartment $apartments */
        $apartments = $apartmentRepo->getAll();

        return $this->render('admin/home.html.twig', [
            'apartments' => $apartments
        ]);

    }
}