<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Beneficiary;
use AppBundle\Entity\RelationshipType;
use AppBundle\Form\BeneficiaryFormType;
use Pagerfanta\Adapter\DoctrineDbalAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class BeneficiaryController extends Controller
{

    /**
     * @Route("/beneficiary-list", name="list_beneficiary")
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

        //Your custom Doctrine DBAL Query
        //// for getting list of All Benefits
      $qb1 = $em->getRepository('AppBundle:Beneficiary')
            ->findAllBeneficiary();

        //Your custom Doctrine DBAL Query for counting the number of All Benefits
        $qb2 = $em->getRepository('AppBundle:Beneficiary')
            ->countAllBeneficiary($qb1);

        //This is a custom Library (PagerFanta that helps us to Paginate Our Results Page)
        $adapter =new DoctrineDbalAdapter($qb1,$qb2);
        $data = new Pagerfanta($adapter);
        $data->setMaxPerPage($maxPerPage);
        $data->setCurrentPage($page);
        $data->getCurrentPageResults();

        //Render the output
        return $this->render(
            'member/beneficiary_list.html.twig',array(
                'records'=>$data,
                'title'=>'List of Beneficiaries',
        ));
    }

    /**
     * @Route("/add-beneficiary", name="add_beneficiary")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(BeneficiaryFormType::class);

        dump($form);

        // only handles data on POST
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $this->addFlash('success','Beneficiary successfully created');

            return $this->redirectToRoute('list_beneficiary');
        }

        return $this->render(
            'member/beneficiary.html.twig',
            array(
                'form'=>$form->createView(),
            )

        );
    }


    /**
     * @Route("/edit-beneficiary/{beneficiaryId}", name="edit_beneficiary",defaults={"beneficiaryId" = null})
     * @param Request $request
     * @param Beneficiary $beneficiaryId
     * @return Response
     */
    public function editAction(Request $request,Beneficiary $beneficiaryId)
    {
        $form = $this->createForm(BeneficiaryFormType::class,$beneficiaryId);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $this->addFlash('success', 'Beneficiary successfully updated!');

            return $this->redirectToRoute('list_beneficiary');
        }

        return $this->render(
            'member/beneficiary.html.twig',
            array(
                'form'=>$form->createView(),
            )

        );
    }

    /**
     * @Route("/delete-Beneficiary/{beneficiaryId}", name="delete_beneficiary",defaults={"beneficiaryId" = null})
     * @param $beneficiaryId
     * @return Response
     * @internal param Request $request
     */
    public function deleteAction($beneficiaryId)
    {
        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('AppBundle:Beneficiary')->find($beneficiaryId);

        if($data instanceof Beneficiary)
        {
            $em->remove($data);
            $em->flush();
            $this->addFlash('success', 'Beneficiary successfully removed !');
        }
        else
        {
            $this->addFlash('error', 'Beneficiary not found !');
        }

        
        return $this->redirectToRoute('list_beneficiary');

    }
    
}