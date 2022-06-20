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
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("formation/lire/{id}", name="app-formation", methods={"GET"})
     */
    public function getutilisateur(Formation $formation)
    {
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

    /**
     * @Route("/formation/ajout", name="ajout-formation", methods={"POST"})
     */
    public function addoffre(Request $request)
    {

        $formation = new Formation();
        $donnees = json_decode($request->getContent());
        $formation->setTitreFormation($donnees->titre_formation);
        $formation->setDescription($donnees->description);
        $formation->setCentreFormation($donnees->centre_formation);
        $formation->setInfo($donnees->info);
        $formation->setWeb($donnees->web);
        $formation->setEmail($donnees->email);
        $formation->setHeure($donnees->heure);
        $formation->setCout($donnees->cout);
        $formation->setExamen($donnees->examen);
        $formation->setFormateur($donnees->formateur);
        $formation->setImage($donnees->image);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($formation);
        $entityManager->flush();

        return new JsonResponse('ok');
    }

    /**
     * @Route("/formation/supprimer/{id}", name="supprime-formation", methods={"DELETE"})
     */
    public function removeuser(Formation $formation)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($formation);
        $entityManager->flush();
        return new JsonResponse('ok');
    }
}
