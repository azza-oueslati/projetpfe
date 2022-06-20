<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Offre;
use DateTimeInterface;
use App\Form\OffreType;
use App\Form\EditOffreType;
use App\Form\EditProfileType;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Security\Core\User\User as UserUser;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class OffreController extends AbstractController
{


    /**
     * @Route("/offres" , name="offres", methods={"GET"})
     */
    public function offresList(OffreRepository $offre)
    { {

            $offre = $offre->findAll();


            $encoders = [new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);

            $jsonContent = $serializer->serialize($offre, 'json', [
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
     * @Route("/offre/lire/{id}", name="offre", methods={"GET"})
     */
    public function getoffre(Offre $offre)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($offre, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    /**
     * @Route("/offre/supprimer/{id}", name="supprime-offre", methods={"DELETE"})
     */
    public function removeoffre(Offre $offre)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($offre);
        $entityManager->flush();
        return new JsonResponse('ok');
    }
    /**
     * @Route("/offre/ajout", name="ajout", methods={"POST"})
     */
    public function addoffre(Request $request)
    {

        $offre = new Offre();
        $donnees = json_decode($request->getContent());
        $offre->setTitreOffre($donnees->titre_offre);
        $offre->setRegionOffre($donnees->region_offre);
        $offre->setDescription($donnees->description);
        $offre->setExigences($donnees->exigences);
        $offre->setDateExpiration(new \DateTime());
        $offre->setSociete($donnees->societe);
        $offre->setPostesVacants($donnees->postesVacants);
        $offre->setNiveauEtude($donnees->niveauEtude);
        $offre->setTypeEmploiDesire($donnees->typeEmploiDesire);
        $offre->setLangue($donnees->langue);
        $offre->setExperience($donnees->experience);
        $offre->setGenre($donnees->genre);
        $offre->setImage($donnees->image);





        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($offre);
        $entityManager->flush();

        return new JsonResponse('ok');
    }
    /**
     * @Route("/offre/editer/{id}", name="edit", methods={"PUT"})
     */
    public function editArticle(?Offre $offre, Request $request)
    {
        $donnees = json_decode($request->getContent());
        $code = 200;
        if (!$offre) {

            $offre = new Offre();

            $code = 201;
        }

        $offre->setTitreOffre($donnees->titre_offre);
        $offre->setRegionOffre($donnees->region_offre);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($offre);
        $entityManager->flush();


        return new JsonResponse('ok');
    }
}
