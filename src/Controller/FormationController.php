<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
    /**
     * @Route("/formation" , name="formation", methods={"GET"})
     */
    public function listformation(FormationRepository $formation)
    { {

            $formation = $formation->findAll();
            $encoders = [new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);

            $jsonContent = $serializer->serialize($formation, 'json', [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]);
            $response = new Response($jsonContent);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }

    /**
     * @Route("/ajout_formation", name="app_formation")
     */
    public function add(EntityManagerInterface $manager, Request $request)
    {
        $form = $this->createForm(FormationType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formation = $form->getData();
            $manager->persist($formation);
            $manager->flush();
            $this->addFlash(
                'notice',
                'super ! une nouvelle formation à été ajoutée !'
            );
            return $this->redirectToRoute('formation');
        }
        return $this->render('formation/ajout_formation.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
