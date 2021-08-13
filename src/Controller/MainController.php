<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Personne;
use App\Form\EquipeType;
use App\Form\PersonneType;
use App\Repository\EquipeRepository;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home(EquipeRepository $repoEquipe, PersonneRepository $repoPersonne): Response
    {

        $personne = new  Personne();
        $PersonneForm = $this->createForm(PersonneType::class, $personne);
        $equipe = new Equipe();
        $EquipeForm = $this->createForm(EquipeType::class,$equipe);
        return $this->render('index.html.twig', [
            'equipeForm' => $EquipeForm->createView(),
            'equipes' => $repoEquipe->findAll(),
            'personneForm' => $PersonneForm->createView(),
            'personnes' => $repoPersonne->findAll(),


        ]);
        dd('personnes');

    }




    /**
     * @Route("/ajouter/equipe/", name="equipe_ajouter")
     */
    public function ajouterEquipe(Request $request, EntityManagerInterface $em): Response
    {
        //dd('route ajouter equipe');
        ///$em = $this->getDoctrine()->getManager();
        $equipe = new Equipe();
        $equipeForm = $this->createForm(EquipeType::class, $equipe);
        $equipeForm->handleRequest($request);
        if ($equipeForm->isSubmitted() && $equipeForm->isValid()) {
            $em->persist($equipe);
            $em->flush();
        }
        return $this->redirectToRoute('home');
    }


    /**
     * @Route("/ajouter/personne/", name="personne_ajouter")
     */
    public function personneAjouter(Request $request, EntityManagerInterface $em): Response
    {
        //dd('route ajouter equipe');
        ///$em = $this->getDoctrine()->getManager();
        $personne = new Personne();
        $personneForm = $this->createForm(PersonneType::class, $personne);
        $personneForm->handleRequest($request);
        if ($personneForm->isSubmitted() && $personneForm->isValid()) {
            $em->persist($personne);
            $em->flush();
        }
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/equipe_enlever{id}", name="equipe_enlever")
     */
    public function equipe_enlever(Equipe $equipe, EntityManagerInterface $em):Response
    {

        //autre méthode (vider les paramètres de ajouter ())
        //$em = $this->getDoctrine()->getManager();
        $em->remove($equipe);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/personne_enlever{id}", name="personne_enlever")
     */
    public function personne_enlever(Personne $personne, EntityManagerInterface $em):Response
    {

        //autre méthode (vider les paramètres de ajouter ())
        //$em = $this->getDoctrine()->getManager();
        $em->remove($personne);
        $em->flush();

        return $this->redirectToRoute('home');
    }
}
