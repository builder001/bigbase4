<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    /**
     * @Route("admin/menu/new")
     */
    public function new(EntityManagerInterface $em)
    {
        $menu = new Menu();
        $menu->setTitle('Users')
            ->setController('/user')
            ->setAction('index')
            ->setPosition('1');
        $em->persist($menu);

        $menu1 = new Menu();
        $menu1->setTitle('Permission')
            ->setController('/permission')
            ->setAction('index')
            ->setPosition('2');
        $em->persist($menu1);

        $menu2 = new Menu();
        $menu2->setTitle('Study')
            ->setController('/study')
            ->setAction('index')
            ->setPosition('3');
        $em->persist($menu2);

        $menu3 = new Menu();
        $menu3->setTitle('Input Results')
            ->setController('/resultinput')
            ->setAction('index')
            ->setPosition('4');
        $em->persist($menu3);

        $menu4 = new Menu();
        $menu4->setTitle('Show Results')
            ->setController('/resultshow')
            ->setAction('index')
            ->setPosition('5');
        $em->persist($menu4);

        $menu5 = new Menu();
        $menu5->setTitle('Query')
            ->setController('/resultquery')
            ->setAction('index')
            ->setPosition('6');
        $em->persist($menu5);

        $menu6 = new Menu();
        $menu6->setTitle('Search')
            ->setController('/search')
            ->setAction('index')
            ->setPosition('7');
        $em->persist($menu6);


        $em->flush();

        return new Response(sprintf('New Menu id: #%d controller: %s',$menu->getId(),$menu->getController()));
    }
}