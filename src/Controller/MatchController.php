<?php

namespace App\Controller;

use App\Entity\Matche;
use App\Form\MatcheType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchController extends AbstractController
{
    #[Route('/admin/match', name:'matchA_read')]
    public function read(ManagerRegistry $doctrine): Response
    {
        $Matches = $doctrine->getRepository(Matche::class)->findBy(array('etat' => array('Complet', 'Ouvert', 'Privée')));
        return $this->render('match/index.html.twig', ["matches"=>$Matches]);
    }

    #[Route('/match', name:'match_view')]
    public function readF(ManagerRegistry  $doctrine): Response
    {
        $Matches = $doctrine->getRepository(Matche::class)->findBy(array('etat' => array('Complet', 'Ouvert', 'Privée')));
        return $this->render('match/indexF.html.twig', ["matches"=>$Matches]);
    }

    #[Route('/match/add', name:'add_match')]
    public function addMatchF(ManagerRegistry  $doctrine, Request $request): Response
    {
        $Matches = $doctrine->getRepository(Matche::class)->findBy(array('etat' => array('Complet', 'Ouvert', 'Privée')));
        $match = new Matche();
        $form = $this->createForm(MatcheType::class, $match);
        $form->add('Creer', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $doctrine->getManager();
            $em->persist($match);
            $em->flush();
            return $this->redirectToRoute('match_view');
        }
        return $this->render('match/matchAdd.html.twig', ["matches"=>$Matches, "f"=> $form->createView()]);
    }

    #[Route('/admin/match/edit/{id}', name:'match_edit')]
    public function edit_matchB(ManagerRegistry  $doctrine, Request $request, $id): Response
    {
        $Matches = $doctrine->getRepository(Matche::class)->findBy(array('etat' => array('Complet', 'Ouvert', 'Privée')));
        $match = $doctrine->getRepository(Matche::class)->find($id);
        $form = $this->createForm(MatcheType::class, $match);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('matchA_read');
        }
        return $this->render('match/matchEdit.html.twig', ["matches"=>$Matches, "f" => $form->createView()]);
    }

    #[Route('/admin/match/delete/{id}', name:'matchA_delete')]
    public function del_matchA(ManagerRegistry $doctrine, $id): Response
    {
        $matche = $doctrine->getRepository(Matche::class)->find($id);
        $em = $doctrine->getManager();
        $em->remove($matche);
        $em->flush();
        return $this->redirectToRoute("matchA_read");
    }


}
