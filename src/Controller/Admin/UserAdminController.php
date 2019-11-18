<?php

namespace App\Controller\Admin;


use App\Entity\User;
use App\Form\UserForm;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @Security("is_granted('ROLE_ADMIN')")
 * @package App\Controller\Admin
 * @Route("admin/user")
 */
class UserAdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_user_index")
     */
    public function index(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(User::class);
        $users = $repository->findAll();
        return $this->render('admin/user/index.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/new", name="admin_user_new")
     */
    public function new(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserForm::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success','user.created_successfully');

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/user/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/show/{id}",requirements={"id":"\d+"}, name="admin_user_show")
     * @param User $users
     * @return Response
     */
    public function show(User $users)
    {
        return $this->render('admin/user/show.html.twig',['users' => $users]);
    }

    /**
     * @Route("/{id}/delete", name="admin_user_delete")
     * @param Request $request
     * @param User $users
     * @return Response
     */
    public function delete(Request $request, User $users):Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_user_index');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($users);
        $em->flush();
        $this->addFlash('success','user.deleted_successfully');

        return $this->redirectToRoute('admin_user_index');
    }

}