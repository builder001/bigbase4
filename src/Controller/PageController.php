<?php

namespace App\Controller;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homepage(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Menu::class);
        /**@var Menu $menu**/
        $menu = $repository->findAll();
        if (!$menu) {
            throw $this->createNotFoundException(sprintf('No menu item found'));
        }

        return $this->render('page/home.html.twig',['menu' => $menu]);
    }
}