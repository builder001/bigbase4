<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/new", name="user_new")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function new(EntityManagerInterface $em)
    {
        $user = new User();
        $user->setEmail('sourcein101@gmail.com');
        $user->setPlainPassword('iliketurtles');
        $user->setRoles(['ROLE_ADMIN']);

        $em->persist($user);
        $em->flush();

        return new Response(sprintf('User added', $user->getUsername()));
    }

    /**
     * @param Request $request
     * @Route("/register", name="user_register")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $form = $this->createForm(UserRegistrationForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Welcome '.$user->getEmail());
            return $this->redirectToRoute('app_homepage');
        }
        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}