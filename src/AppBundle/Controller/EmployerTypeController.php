<?php

namespace AppBundle\Controller;

use AppBundle\Entity\EmployerType;
use AppBundle\Form\EmployerTypeForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pagerfanta\Adapter\DoctrineDbalAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class EmployerTypeController extends Controller
{
    /**
     * @Route("/employer-type-list", name="list_employer_type")
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
        $qb1 = $em->getRepository('AppBundle:EmployerType')
            ->findAllEmployerType();

        //Your custom Doctrine DBAL Query for counting the number of All Benefits
        $qb2 = $em->getRepository('AppBundle:EmployerType')
            ->countAllEmployerType($qb1);

        //This is a custom Library (PagerFanta that helps us to Paginate Our Results Page)
        $adapter =new DoctrineDbalAdapter($qb1,$qb2);
        $data = new Pagerfanta($adapter);
        $data->setMaxPerPage($maxPerPage);
        $data->setCurrentPage($page);
        $data->getCurrentPageResults();

        //Render the output
        return $this->render(
            'lists/employer_type.html.twig',array(
            'records'=>$data,
            'title'=>'List of Employer Types',
        ));
    }

    /**
     * @Route("/add-employer-type", name="add_employer_type")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(EmployerTypeForm::class);

        // only handles data on POST
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $this->addFlash('success','Employer Type successfully created');

            return $this->redirectToRoute('list_employer_type');
        }

        return $this->render(
            'forms/employer_type.html.twig',
            array(
                'form'=>$form->createView(),
            )
        );
    }


    /**
     * @Route("/edit-employer-type/{employerTypeId}", name="edit_employer_type",defaults={"employerTypeId" = null})
     * @param Request $request
     * @param EmployerType $employer_type
     * @return Response
     */
    public function editAction(Request $request,EmployerType $employer_type)
    {
        $form = $this->createForm(EmployerTypeForm::class,$employer_type);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $this->addFlash('success', 'Employer Type successfully updated!');

            return $this->redirectToRoute('list_employer_type');
        }

        return $this->render(
            'forms/employer_type.html.twig',
            array(
                'form'=>$form->createView(),
            )

        );
    }

    /**
     * @Route("/delete-employer-type/{employerTypeId}", name="delete_employer_type",defaults={"employerTypeId" = null})
     * @param $employerTypeId
     * @return Response
     * @internal param Request $request
     */
    public function deleteAction($employerTypeId)
    {
        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('AppBundle:EmployerType')->find($employerTypeId);

        if($data instanceof EmployerType)
        {
            $em->remove($data);
            $em->flush();
            $this->addFlash('success', 'Employer Type successfully removed !');
        }
        else
        {
            $this->addFlash('error', 'Employer Type not found !');
        }


        return $this->redirectToRoute('list_employer_type');

    }
}
