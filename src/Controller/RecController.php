<?php

namespace App\Controller;

use App\Entity\Recruteur;
use App\Entity\User;
use App\Repository\RecruteurRepository;
use App\Repository\UserRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RecController extends AbstractController
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/rec", name="app_rec")
     */
    public function index(): Response
    {
        return $this->render('rec/index.html.twig', [
            'controller_name' => 'RecController',
        ]);
    }
    /**
     * @Route("/recruteur" , name="list-rec", methods={"GET"})
     */
    public function usersList(RecruteurRepository $recruteur)

    {


        $recruteur = $this->userRepository->findUserByRole('CANDIDAT');

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);


        $jsonContent = $serializer->serialize($recruteur, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        $response = new Response($jsonContent);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("recruteur/lire/{id}", name="recruteur", methods={"GET"})
     */
    public function getrecruteur(User $recruteur)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($recruteur, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/ajout" , name="ajout_recruteur", methods={"POST"})
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $donnees = json_decode($request->getContent());

        $recruteur =  $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $donnees->email]);

        if ($recruteur != null) {
            return new JsonResponse('this email exist');
        }

        $user = new User();
        $user->setEmail($donnees->email);
        $user->setUsername($donnees->username);
        $user->setPassword($encoder->encodePassword($user, $donnees->password));
        $user->setPrenom($donnees->nom);
        $user->setAdresse($donnees->adresse);
        $user->setRoles(['ROLE_RECRUTEUR']);

        $recruteur = new Recruteur();
        $recruteur->setSite($donnees->site);
        $recruteur->setTelephone($donnees->telephone);
        $recruteur->setDescription($donnees->description);
        $recruteur->setSecteur($donnees->secteur);
        $recruteur->setUser($user);

        $entityManager->persist($recruteur);
        $entityManager->flush();

        return new JsonResponse('ok');
    }
    /**
     * @Route("/recruteur/editer/{id}", name="modifier", methods={"PUT"})
     */
    public function editrec(?User $recruteur, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $donnees = json_decode($request->getContent());
        $code = 200;
        if (!$recruteur) {

            $recruteur = new recruteur();

            $code = 201;
        }

        $recruteur->setEmail($donnees->email);
        $recruteur->setPassword($encoder->encodePassword($recruteur, $donnees->password));
        $recruteur->setPrenom($donnees->nom);
        $recruteur->setAdresse($donnees->adresse);
        $recruteur->getRecruteur()->setSite($donnees->site);
        $recruteur->getRecruteur()->setTelephone($donnees->telephone);
        $recruteur->getRecruteur()->setDescription($donnees->description);
        $recruteur->getRecruteur()->setSecteur($donnees->secteur);




        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($recruteur);
        $entityManager->flush();


        return new JsonResponse('ok');
    }

    /**
     * @Route("/recruteur/supprimer/{id}", name="supp", methods={"DELETE"})
     */
    public function removerecruteur(Recruteur $recruteur)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($recruteur);
        $entityManager->flush();
        return new JsonResponse('ok');
    }
}
