<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contribution;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\ContributionForm;
use Pagerfanta\Adapter\DoctrineDbalAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContributionController extends Controller
{
    /**
     * @Route("/contribution-list", name="list_contribution")
     * @param Request $request
     * @return Response
     *
     */
    public function listAction(Request $request,$member_employer_id)
    {

        //This is a query string parameter that lets us know which page we are viewing
        $page = $request->query->get('page',1);

        //This is a user defined parameter that tells us the maximum results to render per page
        $maxPerPage = $this->getParameter('grid_per_page_limit');

        //Your entity manager for manipulating database connections
        $em = $this->getDoctrine()->getManager();

        //Your custom Doctrine DBAL Query for getting list of All Benefits
        $qb1 = $em->getRepository('AppBundle:Contribution')
            ->AllContribution($member_employer_id);

        //Your custom Doctrine DBAL Query for counting the number of All Benefits
        $qb2 = $em->getRepository('AppBundle:Contribution')
            ->CountMemberContr($qb1);

        //This is a custom Library (PagerFanta that helps us to Paginate Our Results Page)
        $adapter =new DoctrineDbalAdapter($qb1,$qb2);
        $data = new Pagerfanta($adapter);
        $data->setMaxPerPage($maxPerPage);
        $data->setCurrentPage($page);
        $data->getCurrentPageResults();

        //Render the output
        return $this->render(
            'lists/contribution.html.twig',array(
            'records'=>$data,
            'title'=>'List of Contributions',
        ));
    }

    /**
     * @Route("/add-contribution", name="add_contribution")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(ContributionForm::class);

        // only handles data on POST
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $this->addFlash('success','Contribution successfully created');

            return $this->redirectToRoute('list_contribution');
        }

        return $this->render(
            'forms/contribution.html.twig',
            array(
                'form'=>$form->createView(),
            )
        );
    }


    /**
     * @Route("/edit-contribution/{contributionId}", name="edit_contribution",defaults={"contributionId" = null})
     * @param Request $request
     * @param Contribution $contribution
     * @return Response
     */
    public function editAction(Request $request,Contribution $contribution)
    {
        $form = $this->createForm(ContributionForm::class,$contribution);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $this->addFlash('success', 'Contribution successfully updated!');

            return $this->redirectToRoute('list_contribution');
        }
        return $this->render(
            'forms/contribution.html.twig',
            array(
                'form'=>$form->createView(),
            )
        );
    }

    /**
     * @Route("/delete-contribution/{contributionId}", name="delete_contribution",defaults={"contributionId" = null})
     * @param $contributionId
     * @return Response
     * @internal param Request $request
     */
    public function deleteAction($contributionId)
    {
        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('AppBundle:Contribution')->find($contributionId);

        if($data instanceof Contribution)
        {
            $em->remove($data);
            $em->flush();
            $this->addFlash('success', 'Contribution successfully removed !');
        }
        else
        {
            $this->addFlash('error', 'Contribution not found !');
        }


        return $this->redirectToRoute('list_contribution');

    }
}
