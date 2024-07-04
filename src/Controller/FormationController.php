<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
    #[Route('/formation/{id}', name: 'app_formation')]
    public function index(FormationRepository $formationRepository, int $id): Response
    {
        //$formation = $entityManager->getRepository(Formation::class)->find($id);
        $formation = $formationRepository->findOneById($id);
        if (!$formation) {
            throw $this->createNotFoundException(
                "La formation " . $id . " existe pas!"
            );
        }
        return $this->render('formation/index.html.twig', [
            'controller_name' => 'FormationController',
            'name' => $formation->getName()
        ]);
    }

    #[Route('/formation-add', name: 'create_formation')]
    public function createFormation(EntityManagerInterface $entityManager): Response
    {
        $formation = new Formation();
        $formation->setName("Laravel 10");
        $formation->setSlug("Laravel-10");
        $formation->setSubtitle("Lorem Ipsum");
        $formation->setDescription("lorem ipsum dolor sit amet.");
        $formation->setImage("Laravel10.jpg");
        $formation->setVideo("I51E68Lw6dc");
        $formation->setLink("https://grafikart.fr/formations/apprendre-symfony-7");
        $entityManager->persist($formation);
        $entityManager->flush();
        return new Response("data have been saved");
    }
}
