<?php

namespace App\Controller;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Team;
use App\Form\TeamType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/team')]
class TeamController extends AbstractController
{
    #[Route('/index', name: 'app_team')]
    public function index(): Response
    {
        return $this->render('team/index.html.twig', [
            'controller_name' => 'TeamController',
        ]);
    }

    #[Route('/new', name: 'app_new_team')]
    public function new(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($team);
            $entityManager->flush();
            return $this->redirectToRoute("app_new_team");
        }
        return $this->render('Team/newTeam.html.twig',[
            'TeamForm' => $form->createView(),
        ]);
    }




    #[Route('/showall', name: 'app_show_teams')]

    public function read(ManagerRegistry $doctrine): Response
    {
        $Teams = $doctrine->getRepository(Team::class)->findAll();
        return $this->render('team/show.html.twig',
            ["teams"=>$Teams]
        );
    }
    #[Route('/delete/{id}', name: 'app_delete_team')]
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $team = $doctrine->getRepository(Team::class)->find($id);
        if (!$team) {
            throw $this->createNotFoundException(
                'Team already deleted '
            );
        }
        $doctrine->getManager()->remove($team);
        $doctrine->getManager()->flush();
        return $this->RedirecttoRoute("app_show_teams");
    }
    #[Route('/show/{id}', name: 'app_show_team')]
    public function showOne(ManagerRegistry $doctrine, $id): Response
    {
        $Team = $doctrine->getRepository(Team::class)->find($id);
        $Players=$Team->getPlayers();
        return $this->render('team/showteam.html.twig',
            ["team"=>$Team, "Players"=>$Players]
        );
    }
    #[Route('/deletePlayer/{id}/{idP}', name: 'app_delete_player_team')]
    public function deletePlayer(ManagerRegistry $doctrine, $id, $idP): Response
    {
        $team = $doctrine->getRepository(Team::class)->find($id);
        $player= $doctrine->getRepository(User::class)->find($idP);
        $team->removePlayer($player);
        $doctrine->getManager()->flush();
        return $this->RedirecttoRoute("app_show_team", ['id'=>$id]);
    }

}
