<?php

namespace AppBundle\Controller\Configuration;

use AppBundle\Entity\Configuration\BusinessType;
use AppBundle\Entity\Configuration\Company;
use AppBundle\Form\Configuration\BusinessTypeFormType;
use AppBundle\Form\Configuration\CompanyFormType;
use Pagerfanta\Adapter\DoctrineDbalAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class BusinessTypeController extends Controller
{

    /**
     * @Route("/administration/business-type", name="business_type_list")
     * @param Request $request
     * @return Response
     *
     */
    public function listAction(Request $request)
    {
        $class = get_class($this);
        
        $this->denyAccessUnlessGranted('view',$class);

        $page = $request->query->get('page',1);
        $options['sortBy'] = $request->query->get('sortBy');
        $options['sortType'] = $request->query->get('sortType');
        $options['name'] = $request->query->get('name');

        $maxPerPage = $this->getParameter('grid_per_page_limit');

        $em = $this->getDoctrine()->getManager();

        $qb1 = $em->getRepository('AppBundle:Configuration\BusinessType')
            ->findAllBusinessTypes($options);

        $qb2 = $em->getRepository('AppBundle:Configuration\BusinessType')
            ->countAllBusinessTypes($qb1);

        $adapter =new DoctrineDbalAdapter($qb1,$qb2);
        $dataGrid = new Pagerfanta($adapter);
        $dataGrid->setMaxPerPage($maxPerPage);
        $dataGrid->setCurrentPage($page);
        $dataGrid->getCurrentPageResults();
        
        //Configure the grid
        $grid = $this->get('app.helper.grid_builder');
        $grid->addGridHeader('S/N',null,'index');
        $grid->addGridHeader('Description','description','text',false);
        $grid->addGridHeader('Actions',null,'action');
        $grid->setStartIndex($page,$maxPerPage);
        $grid->setPath('business_type_list');
        $grid->setCurrentObject($class);
        $grid->setButtons();
        
        //Render the output
        return $this->render(
            'main/app.list.html.twig',array(
                'records'=>$dataGrid,
                'grid'=>$grid,
                'title'=>'Existing Business Types',
                'gridTemplate'=>'lists/base.list.html.twig'
        ));
    }

    /**
     * @Route("/administration/business-type/add", name="business_type_add")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $class = get_class($this);
        
        $this->denyAccessUnlessGranted('add',$class);

        $form = $this->createForm(BusinessTypeFormType::class);

        // only handles data on POST
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $transformer = $this->get('app.helper.url_transformer');
            $data->setIdentifier($transformer->stringToURL($data->getDescription()));
            $em->persist($data);
            $em->flush();

            $this->addFlash('success','Business Type successfully created');

            return $this->redirectToRoute('business_type_list');
        }

        return $this->render(
            'main/app.form.html.twig',
            array(
                'formTemplate'=>'configuration/business.type',
                'form'=>$form->createView(),
                'title'=>'Business Type Details',
            )

        );
    }


    /**
     * @Route("/administration/business-type/edit/{businessTypeId}", name="business_type_edit")
     * @param Request $request
     * @param BusinessType $businessType
     * @return Response
     */
    public function editAction(Request $request,BusinessType $businessType)
    {
        $class = get_class($this);

        $this->denyAccessUnlessGranted('edit',$class);

        $form = $this->createForm(BusinessTypeFormType::class,$businessType);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $data = $form->getData();

            $transformer = $this->get('app.helper.url_transformer');
            $data->setIdentifier($transformer->stringToURL($data->getDescription()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $this->addFlash('success', 'Business type successfully updated!');

            return $this->redirectToRoute('business_type_list');
        }

        return $this->render(
            'main/app.form.html.twig',
            array(
                'formTemplate'=>'configuration/business.type',
                'form'=>$form->createView(),
                'title'=>'Business Type Details',
            )

        );
    }

    /**
     * @Route("/administration/business-type/delete/{businessTypeId}", name="business_type_delete")
     * @param $businessTypeId
     * @return Response
     * @internal param Request $request
     */
    public function deleteAction($businessTypeId)
    {
        $class = get_class($this);
        
        $this->denyAccessUnlessGranted('delete',$class);

        $em = $this->getDoctrine()->getManager();

        $data = $em->getRepository('AppBundle:Configuration\BusinessType')->find($businessTypeId);

        if($data instanceof BusinessType)
        {
            $em->remove($data);
            $em->flush();
            $this->addFlash('success', 'Business type successfully removed !');
        }
        else
        {
            $this->addFlash('error', 'Business type not found !');
        }

        
        return $this->redirectToRoute('business_type_list');

    }
    
}