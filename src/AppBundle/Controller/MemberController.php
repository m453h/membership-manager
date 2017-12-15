<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Member;
use AppBundle\Form\MemberFormType;
use Pagerfanta\Adapter\DoctrineDbalAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class MemberController extends Controller
{

    /**
     * @Route("/member/member-list", name="list_member")
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
      $qb1 = $em->getRepository('AppBundle:Member')
            ->findAllMembers();

        //Your custom Doctrine DBAL Query for counting the number of All Benefits
        $qb2 = $em->getRepository('AppBundle:Member')
            ->countAllMember($qb1);

        //This is a custom Library (PagerFanta that helps us to Paginate Our Results Page)
        $adapter =new DoctrineDbalAdapter($qb1,$qb2);
        $data = new Pagerfanta($adapter);
        $data->setMaxPerPage($maxPerPage);
        $data->setCurrentPage($page);
        $data->getCurrentPageResults();

        //Render the output
        return $this->render(
            'member/member_list.html.twig',array(
                'records'=>$data,
                'title'=>'List of Members',
        ));
    }

    /**
     * @Route("/member/add-member", name="add_member")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(MemberFormType::class);

        // only handles data on POST
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $this->addFlash('success','Member successfully created');

            return $this->redirectToRoute('list_member');
        }

        return $this->render(
            'member/member.html.twig',
            array(
                'form'=>$form->createView(),
            )

        );
    }


    /**
     * @Route("/member/edit-member/{memberId}", name="edit_member",defaults={"memberId" = null})
     * @param Request $request
     * @param Member $member
     * @return Response
     */
    public function editAction(Request $request,Member $member)
    {
        $form = $this->createForm(MemberFormType::class,$member);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $this->addFlash('success', 'Member successfully updated!');

            return $this->redirectToRoute('list_member');
        }

        return $this->render(
            'member/member.html.twig',
            array(
                'form'=>$form->createView(),
            )

        );
    }

    /**
     * @Route("/member/delete-member/{memberId}", name="delete_member",defaults={"memberId" = null})
     * @param $memberId
     * @return Response
     * @internal param Request $request
     */
    public function deleteAction($memberId)
    {
        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('AppBundle:Member')->find($memberId);

        if($data instanceof Member)
        {
            $em->remove($data);
            $em->flush();
            $this->addFlash('success', 'Member successfully removed !');
        }
        else
        {
            $this->addFlash('error', 'Member not found !');
        }

        
        return $this->redirectToRoute('list_member');

    }
    
}