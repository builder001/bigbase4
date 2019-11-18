<?php

namespace App\Controller;

use App\Entity\Study;
use App\Form\StudyForm;
use App\Repository\StudyRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudiesController extends AbstractController
{
    /**
     * @Route("/study", name="study_index")
     * @param StudyRepository $studyRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(StudyRepository $studyRepository)
    {
        $studies = $studyRepository->findAll();

        return $this->render('studies/index.html.twig', ['studies' => $studies]);
    }

    /**
     * @Route("/study/new", name="study_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $study = new Study();
        $form = $this->createForm(StudyForm::class, $study);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($study);
            $em->flush();
            $this->addFlash('success', 'study.created_successfully');

            return $this->redirectToRoute('study_index');
        }

        return $this->render('studies/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/study/show/{id}", requirements={"id" : "\d+"}, name="study_show")
     * @param Study $study
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Study $study)
    {
        return $this->render('studies/show.html.twig', ['study' => $study]);
    }

    /**
     * @Route("/study/{id}/delete", name="study_delete")
     * @Method("POST")
     * @param Request $request
     * @param Study $study
     * @return Response
     */
    public function delete(Request $request, Study $study): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('study_index');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($study);
        $em->flush();
        $this->addFlash('success', 'study.deleted_successfully');

        return $this->redirectToRoute('study_index');
    }
}