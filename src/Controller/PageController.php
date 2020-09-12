<?php


namespace App\Controller;


use App\Entity\Apartment;
use App\Entity\Floor;
use App\Repository\ApartmentRepository;
use App\Repository\FloorRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @var Collection|Floor[]
     */
    private $floors;

    public function __construct(FloorRepository $floorRepo)
    {
        $this->floors = $floorRepo->getAll();
    }

    /**
     * @Route("/", name="home")
     * @param ApartmentRepository $apartmentRepo
     * @return Response
     */
    public function index(ApartmentRepository $apartmentRepo)
    {
        $apartments = $apartmentRepo->getAll();

        return $this->render('pages/home.html.twig', [
            'floors' => $this->floors,
            'apartments' => $apartments
        ]);
    }

    /**
     * @Route("/floor/{floor}", name="floor")
     * @param Floor $floor
     * @return Response
     */
    public function floor(Floor $floor)
    {
        $floorApartments = $floor->getApartments();


        return $this->render('pages/floor.html.twig', [
            'floor' => $floor,
            'floors' => $this->floors,
            'floorApartments' => $floorApartments
        ]);
    }

    /**
     * @Route("/apartment/{apartment}", name="apartment")
     * @param Apartment $apartment
     * @param Finder $finder
     * @param Filesystem $filesystem
     * @return Response
     */
    public function apartment(Apartment $apartment, Finder $finder, Filesystem $filesystem)
    {
        $checkDir = $filesystem->exists('assets/img/apartamenti/'.$apartment->getId());
        $images = [];
        if($checkDir != false){
            $finder->files()->in('assets/img/apartamenti/'.$apartment->getId());
            if($finder->hasResults()){

                foreach ($finder as $file){
                    $images[] = $file->getFilename();
                }
            }
        }
        return $this->render('pages/apartment.html.twig', [

            'apartment' => $apartment,
            'images' => $images,
            'floors' => $this->floors
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('pages/about.html.twig', [

            'floors'=> $this->floors
        ]);
    }
}