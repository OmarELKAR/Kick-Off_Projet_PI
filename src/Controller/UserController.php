<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UpdateFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/user/update/', name: 'app_user_update')]
    public function update(Request $request, ManagerRegistry $doctrine , EntityManagerInterface $entityManager): Response
    {

        $id = $this->getUser()->getId();
        $user = $doctrine->getRepository(User::class)->find($id);
        $form = $this->createForm(UpdateFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute("app_testF");
        }
        return $this->render('user/update.html.twig',[
        'updateForm' => $form->createView(),
         ['user'=>$user],
        ]);
    }

}
