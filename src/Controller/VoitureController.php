<?php

namespace App\Controller;

use App\Entity\Voiture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends AbstractController
{
    /**
     * @Route("/voiture", name="voiture")
     */
    public function index(): Response
    {
        return $this->render('voiture/index.html.twig', [
            'controller_name' => 'VoitureController',
        ]);
    }

    /**
     * @Route("/listVoiture",name="listVoiture")
     */
    public function listVoiture(Request $request)
    {
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findAll();
        return $this->render("voiture/list.html.twig",
            array('tabVoitures' => $voitures
            ));
    }

    /**
     * @Route("/deleteVoiture/{id}", name="deleteVoiture")
     */
    public function deleteVoiture($id): Response
    {
        $voiture = $this->getDoctrine()->getRepository(Voiture::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $this->getDoctrine()->getManager()->remove($voiture);
        $em->flush();
        return $this->redirectToRoute("listVoiture");
    }
}
