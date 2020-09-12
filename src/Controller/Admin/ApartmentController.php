<?php


namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ApartmentController extends AbstractController
{
    /**
     * @Route("/luxadmin/apartment/add" , name="create_apartment")
     */
    public function create(){

    }

    /**
     * @Route("luxadmin/apartment/{apartment}", name="view_apartment")
     */
    public function view(){

    }
    /**
     * @Route("/luxadmin/apartment/edit/{apartment}", name="edit_apartment")
     */
    public function edit(){

    }

    /**
     * @Route("/luxadmin/apartment/delete/{apartment}", name="delete_apartment")
     */
    public function delete(){

    }

}