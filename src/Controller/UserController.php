<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Utilisateur;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * @Route("/user", name="app_user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
     * @Route("/utilisateurs" , name="utilisateurs", methods={"GET"})
     */
    public function usersList()

    {

        $users = $this->userRepository->findUserByRole('USER');

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);


        $jsonContent = $serializer->serialize($users, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        $response = new Response($jsonContent);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     * @Route("user/lire/{id}", name="user", methods={"GET"})
     */
    public function getutilisateur(User $user)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($user, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/inscription" , name="security_registration", methods={"POST"})
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $donnees = json_decode($request->getContent());

        $user =  $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $donnees->email]);

        if ($user != null) {
            return new JsonResponse('this email exist');
        }
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $donnees->username]);
        if ($user != null) {
            return new JsonResponse('this username exist');
        }

        $user = new User();
        $user->setUsername($donnees->username);
        $user->setEmail($donnees->email);
        $user->setAdresse($donnees->adresse);
        $user->setPassword($encoder->encodePassword($user, $donnees->password));
        $user->setRoles(['ROLE_USER']);
        $user->setPrenom($donnees->prenom);

        $candidat = new Utilisateur();
        $candidat->setCivilite($donnees->civilite);
        $candidat->setNaissance(new \DateTime($donnees->naissance));
        $candidat->setUser($user);

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse('ok');
    }


    /**
     * @Route("/user/editer/{id}", name="edit", methods={"PUT"})
     */
    public function edituser(?User $user, Request $request)
    {
        $donnees = json_decode($request->getContent());
        $code = 200;
        if (!$user) {

            $user = new Utilisateur();

            $code = 201;
        }

        $user->setUsername($donnees->username);
        $user->setEmail($donnees->email);
        $user->setAdresse($donnees->adresse);
        $user->getCandidat()->setCivilite($donnees->civilite);
        $user->setPrenom($donnees->prenom);
        $user->getCandidat()->setNaissance(new \DateTime($donnees->naissance));




        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();


        return new JsonResponse('ok');
    }




    /**
     * @Route("/user/supprimer/{id}", name="supprime", methods={"DELETE"})
     */
    public function removeuser(User $user)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        return new JsonResponse('ok');
    }
}
