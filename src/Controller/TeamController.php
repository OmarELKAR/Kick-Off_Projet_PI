<?php

namespace App\Controller;

use App\Entity\Matche;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    #[Route('/admin/team', name: 'app_team')]
    public function read(ManagerRegistry $doctrine): Response
    {
        $Matches = $doctrine->getRepository(Matche::class)->findAll();
        return $this->render('team/index.html.twig', ["matches"=>$Matches]);
    }

    #[Route('/teamComp', name: 'app_teamC')]
    public function indexComp(): Response
    {
        return $this->render('backComp.html.twig', [
            'controller_name' => 'TeamController',
        ]);
    }
}
