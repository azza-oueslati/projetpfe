<?php

namespace App\Controller;

use App\Form\ConseilType;
use App\Repository\ConseilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConseilController extends AbstractController
{
    /**
     * @Route("/conseil" , name="conseil", methods={"GET"})
     */
    public function listactualite(ConseilRepository $conseil)
    {

        $conseil = $conseil->findAll();
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($conseil, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/ajout_conseil", name="app_conseil")
     */
    public function add(EntityManagerInterface $manager, Request $request)
    {
        $form = $this->createForm(ConseilType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $conseil = $form->getData();
            $manager->persist($conseil);
            $manager->flush();
            $this->addFlash(
                'notice',
                'super ! une nouvelle formation à été ajoutée !'
            );
            return $this->redirectToRoute('conseil');
        }
        return $this->render('conseil/ajout_conseil.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
