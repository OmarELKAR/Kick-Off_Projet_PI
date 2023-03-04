<?php
namespace App\Controller;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class UserApiController extends AbstractController {
#[Route ('/registerMob', name: 'app_mob_register')]
public function AddUser(Request $request, UserPasswordHasherInterface $PasswordHasher, EntityManagerInterface $entityManager):Response
{
$email=$request->query->get("email");
$username=$request->query->get("username");
$password=$request->query->get("password");

$user=new User();
$user->setUsername($username);
$user->setEmail($email);
$user->setPassword(
    $PasswordHasher->hashPassword(
        $user,
        $password
    )
);
    $date= new DateTimeImmutable();
    $user->setCreatedAt($date);
    $user->setRoles(['ROLE_USER']);
    $entityManager->persist($user);
    $entityManager->flush();
    return new Response("User added with success");
}

}

