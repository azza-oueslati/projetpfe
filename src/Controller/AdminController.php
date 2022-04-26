<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ManagerRegistry;
use  Doctrine\ORM\EntityManagerInterface;
use App\Entity\Offre;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * @Route("/admin" , name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="accueil", methods={"GET"})
     */
    public function accueil()
    {
        $offre = $this->getDoctrine()->getRepository(Offre::class)->findAll();
        return $this->render('admin/index.html.twig', ['offre' => $offre]);
    }
    /**
     * @Route("/detail", name="detail")
     */
    public function detail(Offre $offre, $id)
    {
        $offre = $this->getDoctrine()->getRepository(Offre::class)
            ->findBy(
                array(
                    'offre' => array('id'),

                )

            );
        return $this->render('admin/detailoffre.html.twig', ['offre' => $offre]);
    }

    /**
     * @Route("/utilisateurs" , name="utilisateurs")
     */
    public function usersList(UserRepository $users)

    {
        // On récupère la liste des articles
        $users = $users->findAll();

        // On spécifie qu'on utilise l'encodeur JSON
        $encoders = [new JsonEncoder()];

        // On instancie le "normaliseur" pour convertir la collection en tableau
        $normalizers = [new ObjectNormalizer()];

        // On instancie le convertisseur
        $serializer = new Serializer($normalizers, $encoders);

        // On convertit en json
        $jsonContent = $serializer->serialize($users, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        // On instancie la réponse
        $response = new Response($jsonContent);

        // On ajoute l'entête HTTP
        $response->headers->set('Content-Type', 'application/json');

        // On envoie la réponse
        return $response;
    }
}
