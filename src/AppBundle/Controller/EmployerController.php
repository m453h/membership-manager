<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Employer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\EmployerTypeForm;
use Pagerfanta\Adapter\DoctrineDbalAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployerController extends Controller
{
    /**
     * @Route("/employer-list", name="list_employer")
     * @param Request $request
     * @return Response
     *
     */
    public function listAction(Request $request)
    {

        //This is a query string parameter that lets us know which page we are viewing
        $page = $request->query->get('page',1);

        //This is a user defined parameter that tells us the maximum results to render per page
        $maxPerPage = $this->getParameter('grid_per_page_limit');

        //Your entity manager for manipulating database connections
        $em = $this->getDoctrine()->getManager();

        //Your custom Doctrine DBAL Query for getting list of All Benefits
        $qb1 = $em->getRepository('AppBundle:Employer')
            ->findAllEmployer();

        //Your custom Doctrine DBAL Query for counting the number of All Benefits
        $qb2 = $em->getRepository('AppBundle:Employer')
            ->countAllEmployer($qb1);

        //This is a custom Library (PagerFanta that helps us to Paginate Our Results Page)
        $adapter =new DoctrineDbalAdapter($qb1,$qb2);
        $data = new Pagerfanta($adapter);
        $data->setMaxPerPage($maxPerPage);
        $data->setCurrentPage($page);
        $data->getCurrentPageResults();

        //Render the output
        return $this->render(
            'lists/employer.html.twig',array(
            'records'=>$data,
            'title'=>'List of Employers',
        ));
    }

    /**
     * @Route("/add-employer", name="add_employer")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(EmployerForm::class);

        // only handles data on POST
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $this->addFlash('success','Employer successfully created');

            return $this->redirectToRoute('list_employer');
        }

        return $this->render(
            'forms/employer.html.twig',
            array(
                'form'=>$form->createView(),
            )
        );
    }


    /**
     * @Route("/edit-employer/{employerId}", name="edit_employer",defaults={"employerId" = null})
     * @param Request $request
     * @param Employer $employer
     * @return Response
     */
    public function editAction(Request $request,Employer $employer)
    {
        $form = $this->createForm(EmployerForm::class,$employer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $this->addFlash('success', 'Employer successfully updated!');

            return $this->redirectToRoute('list_employer');
        }
        return $this->render(
            'forms/employer.html.twig',
            array(
                'form'=>$form->createView(),
            )
        );
    }

    /**
     * @Route("/delete-employer/{employerId}", name="delete_employer",defaults={"employerId" = null})
     * @param $employerId
     * @return Response
     * @internal param Request $request
     */
    public function deleteAction($employerId)
    {
        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('AppBundle:Employer')->find($employerId);

        if($data instanceof EmployerType)
        {
            $em->remove($data);
            $em->flush();
            $this->addFlash('success', 'Employer successfully removed !');
        }
        else
        {
            $this->addFlash('error', 'Employer not found !');
        }


        return $this->redirectToRoute('list_employer');

    }
}
