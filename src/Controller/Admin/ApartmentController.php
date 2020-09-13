<?php


namespace App\Controller\Admin;


use App\Entity\Apartment;
use App\Entity\Image;
use App\Form\ApartmentType;
use App\Repository\ApartmentRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApartmentController extends AbstractController
{
    /**
     * @Route("/luxadmin/apartment/add" , name="create_apartment")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ApartmentRepository $apartmentRepo
     * @param FileUploader $fileUploader
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, EntityManagerInterface $entityManager,
                           ApartmentRepository $apartmentRepo, FileUploader $fileUploader)
    {

        $form = $this->createForm(ApartmentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Apartment $formData */
            $formData = $form->getData();
            $images = $form->get('images')->getData();

            $entityManager->persist($formData);
            $entityManager->flush();
            $lastApartment = $apartmentRepo->getLast();
            $lastInsertId = (string)$lastApartment->getId();
            $targetDir = $this->getParameter('apartments_directory') . $lastInsertId;

            if (!empty($images)) {
                foreach ($images as $image) {
                    $fileUploader->setTargetDir($targetDir);
                    $result = $fileUploader->upload($image);
                    if (!($result instanceof FileException)) {
                        $image = new Image();
                        $image->setName($result);
                        $image->setApartment($lastApartment);
                        $entityManager->persist($image);
                    }
                }
                $entityManager->flush();
            }

            return $this->redirectToRoute('admin_home');

        }

        return $this->render('admin/apartment/manage.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("luxadmin/apartment/{apartment}", name="view_apartment")
     */
    public function view()
    {

    }

    /**
     * @Route("/luxadmin/apartment/edit/{apartment}", name="edit_apartment")
     */
    public function edit()
    {

    }

    /**
     * @Route("/luxadmin/apartment/delete/{apartment}", name="delete_apartment")
     */
    public function delete()
    {

    }

}