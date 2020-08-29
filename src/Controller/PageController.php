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
     * @var FloorRepository
     */
    private $floorRepo;

    public function __construct(FloorRepository $floorRepo)
    {
        $this->floorRepo = $floorRepo;
    }

    /**
     * @Route("/", name="index")
     * @param ApartmentRepository $apartmentRepo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ApartmentRepository $apartmentRepo)
    {
        $floors = $this->floorRepo->getAll();
        $apartments = $apartmentRepo->getAll();

        return $this->render('pages/home.html.twig', [
            'floors' => $floors,
            'apartments' => $apartments
        ]);
    }

    /**
     * @Route("/floor/{floor}", name="floor")
     * @param Floor $floor
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function floor(Floor $floor)
    {
        $floors = $this->floorRepo->getAll();

        $floorApartments = $floor->getApartments();


        return $this->render('pages/floor.html.twig', [
            'floor' => $floor,
            'floors' => $floors,
            'floorApartments' => $floorApartments
        ]);
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