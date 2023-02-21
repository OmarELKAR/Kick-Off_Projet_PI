<?php

namespace App\Controller;

use App\Entity\Tournoi;
use App\Form\TournoiType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TournoiController extends AbstractController
{
    #[Route('admin/tournoi', name: 'showA_tournoi')]
    public function read(ManagerRegistry $doctrine): Response
    {
        $tournois = $doctrine->getRepository(Tournoi::class)->findAll();
        return $this->render('tournoi/index.html.twig', ["tournois"=>$tournois]);
    }

    #[Route('/tournoi', name: 'show_tournoi')]
    public function readF(ManagerRegistry $doctrine): Response
    {
        $tournois = $doctrine->getRepository(Tournoi::class)->findAll();
        return $this->render('tournoi/indexF.html.twig', ["tournois"=>$tournois]);
    }

    #[Route('admin/tournoi/add', name: 'add_tournoi')]
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        $tournois = $doctrine->getRepository(Tournoi::class)->findAll();
        $tournoi = new Tournoi();
        $form = $this->createForm(TournoiType::class, $tournoi);
        $form->add('Creer', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($tournoi);
            $em->flush();
            $tournoi->tournament_matches($doctrine);
            return $this->redirectToRoute('showA_tournoi');
        }
        return $this->render('tournoi/tournoiAdd.html.twig', ["tournois"=>$tournois, "f"=>$form->createView()]);
    }

    #[Route('/admin/tournoi/edit/{id}', name:'tournoi_edit')]
    public function edit_matchB(ManagerRegistry  $doctrine, Request $request, $id): Response
    {
        $Tournois = $doctrine->getRepository(Tournoi::class)->findAll();
        $Tournoi = $doctrine->getRepository(Tournoi::class)->find($id);
        $form = $this->createForm(TournoiType::class, $Tournoi);
        $form->add('Update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('showA_tournoi');
        }
        return $this->render('tournoi/tournoiEdit.html.twig', ["tournois"=>$Tournois, "f" => $form->createView()]);
    }

    #[Route('/admin/tournoi/delete/{id}', name:'tournoi_delete')]
    public function del_tournoi(ManagerRegistry $doctrine, $id): Response
    {
        $tournoi = $doctrine->getRepository(Tournoi::class)->find($id);
        $em = $doctrine->getManager();
        $em->remove($tournoi);
        $em->flush();
        return $this->redirectToRoute("showA_tournoi");
    }

    #[Route('/admin/tournoi/show/{id}', name:'read_tournoi')]
    public function display_tournoiB(ManagerRegistry $doctrine, $id): Response
    {
        $tournoi = $doctrine->getRepository(Tournoi::class)->find($id);
        return $this->render('tournoi/readB.html.twig', ["t"=>$tournoi]);
    }
}
