<?php
declare(strict_types=1);

namespace App\Controller\Admin;


use App\Entity\Apartment;
use App\Entity\Image;
use App\Form\ApartmentType;
use App\Repository\ApartmentRepository;
use App\Service\FileManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApartmentController extends AbstractController
{
    /**
     * @Route("/luxadmin/apartment/add" , name="create_apartment")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ApartmentRepository $apartmentRepo
     * @param FileManager $fileUploader
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $entityManager,
                           ApartmentRepository $apartmentRepo, FileManager $fileUploader)
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
     * @param Apartment $apartment
     */
    public function view(Apartment $apartment)
    {

        return $this->render('admin/apartment/view.html.twig', [
            'apartment' => $apartment
        ]);
    }

    /**
     * @Route("/luxadmin/apartment/edit/{apartment}", name="edit_apartment")
     * @param Request $request
     * @param Apartment $apartment
     * @param EntityManagerInterface $entityManager
     * @param ApartmentRepository $apartmentRepo
     * @param FileManager $fileManager
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, Apartment $apartment, EntityManagerInterface $entityManager, ApartmentRepository $apartmentRepo, FileManager $fileManager)
    {
        $form = $this->createForm(ApartmentType::class, $apartment, ['edit' => true]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            /** @var Apartment $apartmentData */
            $apartmentData = $form->getData();
            $images = $form->get('images')->getData();
            /** @var Image $deleteImages */
            $deleteImages = $form->get('deleteImages')->getData();

            $entityManager->beginTransaction();
            try {
                if(!empty($deleteImages)){
                    $targetDir = $this->getParameter('apartments_directory'). $apartmentData->getId().'/';
                    $fileManager->setTargetDir($targetDir);
                    foreach ($deleteImages as $deleteImage){
                        $fileManager->deleteImage($deleteImage);
                        $entityManager->remove($deleteImage);
                    }
                }

                $entityManager->persist($apartmentData);
                $entityManager->flush();
                $lastApartment = $apartmentRepo->getLast();
                $lastInsertId = (string)$lastApartment->getId();
                $targetDir = $this->getParameter('apartments_directory') . $lastInsertId;

                if (!empty($images)) {
                    foreach ($images as $image) {
                        $fileManager->setTargetDir($targetDir);
                        $result = $fileManager->upload($image);
                        if (!($result instanceof FileException)) {
                            $image = new Image();
                            $image->setName($result);
                            $image->setApartment($lastApartment);
                            $entityManager->persist($image);
                        }
                    }
                    $entityManager->flush();
                }
                $entityManager->commit();
            }catch (\Exception $ex){
                $entityManager->rollback();

            }


            return $this->redirectToRoute('admin_home');

        }

        return $this->render('admin/apartment/manage.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/luxadmin/apartment/delete/{apartment}/{delete}", name="delete_apartment", requirements={"delete"="0|1"}, defaults={"delete" = "0"})
     * @param Apartment $apartment
     * @param string $delete
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function delete(Apartment $apartment, string $delete, EntityManagerInterface $entityManager, FileManager $fileManager)
    {
        if($delete === '1'){
//            $entityManager->remove($apartment);
//            $entityManager->flush();
            $pathToImages = $this->getParameter('apartments_directory');
            $imageDir = $pathToImages. $apartment->getId(). '/';
            $fileManager->setTargetDir($imageDir);
            $fileManager->deleteAll();
            return $this->redirectToRoute('admin_home');
        }
        return $this->render('admin/apartment/delete.html.twig', [
            'apartment' => $apartment
        ]);
    }

}