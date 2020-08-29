<?php


namespace App\Controller;


use App\Entity\Apartment;
use App\Entity\Floor;
use App\Repository\ApartmentRepository;
use App\Repository\FloorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param FloorRepository $floorRepo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(FloorRepository $floorRepo, ApartmentRepository $apartmentRepo)
    {
        $floors = $floorRepo->getAll();
        $apartments = $apartmentRepo->getAll();

        return $this->render('pages/home.html.twig', [
            'floors' => $floors,
            'apartments' => $apartments
        ]);
    }

    /**
     * @Route("/floor/all", name="floor_all")
     */
    public function allFloors(){

    }

    /**
     * @Route("/floor/{floor}", name="floor")
     * @param Floor $floor
     */
    public function floor(Floor $floor)
    {
        dump($floor);
        exit;
    }

    /**
     * @Route("/apartment/{apartment}", name="apartment")
     * @param Apartment $apartment
     */
    public function apartment(Apartment $apartment)
    {
        dump($apartment);
        exit;
    }

    /**
     * @Route("/about", name="about")
     */
    public function about()
    {

    }
}