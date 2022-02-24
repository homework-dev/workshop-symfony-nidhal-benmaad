<?php

namespace App\Controller;

use App\Entity\Chauffeur;
use App\Entity\Voiture;
use App\Form\ChauffeurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChauffeurController extends AbstractController
{
    /**
     * @Route("/chauffeur", name="chauffeur")
     */
    public function index(): Response
    {
        return $this->render('chauffeur/index.html.twig', [
            'controller_name' => 'ChauffeurController',
        ]);
    }

    /**
     * @Route("/listChauffeur",name="listChauffeur")
     */
    public function listChauffeur(Request $request)
    {
        $chauffeurs = $this->getDoctrine()->getRepository(Chauffeur::class)->findAll();
        return $this->render("chauffeur/list.html.twig",
            array('tabChauffeurs' => $chauffeurs
            ));
    }

    /**
     * @Route("/addChauffeur/{id}", name="addChauffeur")
     */
    public function addChauffeur(Request $request, $id): Response
    {
        //var_dump($request->query->all());
        $chauffeur = new Chauffeur();
        $voiture = $this->getDoctrine()->getRepository(Voiture::class)->find($id);
        $form = $this->createForm(ChauffeurType::class, $chauffeur);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($chauffeur);
            $em->flush();
            return $this->redirectToRoute('listVoiture');
        }

        return $this->render("chauffeur/add.html.twig", array('voiture' => $voiture,
            'chauffeurForm' => $form->createView()));
    }
}
