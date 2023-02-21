<?php

namespace App\Controller;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'app_user')]

        public function read(ManagerRegistry $doctrine): Response
    {
        $Users = $doctrine->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig',
            ["users"=>$Users]
        );
    }


    #[Route('/users/delete/{id}', name: 'app_user_delete')]
     public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $user = $doctrine->getRepository(User::class)->find($id);
        if (!$user) {
            throw $this->createNotFoundException(
                'User already deleted '
            );
        }
            $doctrine->getManager()->remove($user);
            $doctrine->getManager()->flush();
        return $this->RedirecttoRoute("app_user");
    }
    public function update(ManagerRegistry $doctrine, $id): Response
    {
        $user = $doctrine->getRepository(User::class)->find($id);

    }

}
