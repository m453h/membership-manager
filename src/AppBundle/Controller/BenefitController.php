<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Benefit;
use AppBundle\Form\BenefitFormType;
use Pagerfanta\Adapter\DoctrineDbalAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class BenefitController extends Controller
{

    /**
     * @Route("/benefit-list", name="list_benefit")
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
        $qb1 = $em->getRepository('AppBundle:Benefit')
            ->findAllBenefits();

        //Your custom Doctrine DBAL Query for counting the number of All Benefits
        $qb2 = $em->getRepository('AppBundle:Benefit')
            ->countAllBenefits($qb1);

        //This is a custom Library (PagerFanta that helps us to Paginate Our Results Page)
        $adapter =new DoctrineDbalAdapter($qb1,$qb2);
        $data = new Pagerfanta($adapter);
        $data->setMaxPerPage($maxPerPage);
        $data->setCurrentPage($page);
        $data->getCurrentPageResults();

        //Render the output
        return $this->render(
            'lists/benefit.html.twig',array(
                'records'=>$data,
                'title'=>'List of Benefits',
        ));
    }

    /**
     * @Route("/add-benefit", name="add_benefit")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(BenefitFormType::class);

        // only handles data on POST
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $this->addFlash('success','Benefit successfully created');

            return $this->redirectToRoute('list_benefit');
        }

        return $this->render(
            'forms/benefit.html.twig',
            array(
                'form'=>$form->createView(),
            )

        );
    }


    /**
     * @Route("/edit-benefit/{benefitId}", name="edit_benefit")
     * @param Request $request
     * @param Benefit $benefit
     * @return Response
     */
    public function editAction(Request $request,Benefit $benefit)
    {
        $form = $this->createForm(BenefitFormType::class,$benefit);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $this->addFlash('success', 'Benefit successfully updated!');

            return $this->redirectToRoute('list_benefit');
        }

        return $this->render(
            'forms/benefit.html.twig',
            array(
                'form'=>$form->createView(),
            )

        );
    }

    /**
     * @Route("/delete-benefit/{benefitId}", name="delete_benefit")
     * @param $benefitId
     * @return Response
     * @internal param Request $request
     */
    public function deleteAction($benefitId)
    {
        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('AppBundle:Benefit')->find($benefitId);

        if($data instanceof Benefit)
        {
            $em->remove($data);
            $em->flush();
            $this->addFlash('success', 'Benefit successfully removed !');
        }
        else
        {
            $this->addFlash('error', 'Benefit not found !');
        }

        
        return $this->redirectToRoute('list_benefit');

    }
    
}