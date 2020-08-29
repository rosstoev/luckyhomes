<?php


namespace App\Controller;


use App\Entity\Apartment;
use App\Entity\Floor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {


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