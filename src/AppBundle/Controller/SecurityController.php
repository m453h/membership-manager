<?php

namespace AppBundle\Controller;


use AppBundle\Form\Accounts\LoginForm;
use AppBundle\Form\Accounts\ResetPasswordForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class SecurityController extends  Controller
{

    /**
     * @Route("/", name="security_login")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $key = '_security.main.target_path'; # where "main" is your firewall name
        $accountStatus = null;
        $form = null;
        $error = null;
        $isAuthenticated = false;
        $isPasswordExpired=false;

        if($this->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            $accountStatus = $this->getUser()->getAccountStatus();
            $isAuthenticated = true;

            $lastPasswordUpdate =  (object) $this->getUser()->getLastPasswordUpdateDate();

            if($lastPasswordUpdate instanceof \DateTime)
            {
                $now = new \DateTime();
                $passwordAge = $now->getTimestamp() - $lastPasswordUpdate->getTimestamp();
                $passwordAge = ($passwordAge/2629746);

                if($passwordAge>($this->getUser()->getPasswordValidity()))
                {
                    $isPasswordExpired = true;
                }
            }
            else
            {
                $isPasswordExpired = true;
            }
        }

        //Check and clear URL redirection
        if ($this->get('session')->has($key))
        {
            if($isAuthenticated)
            {
                if($accountStatus=='I' || $isPasswordExpired==true)
                {
                    $this->get('session')->remove($key);
                }
            }
            else
            {
                $this->addFlash('error','You need to login to view this page');
            }

        }

        //Check which form to generate
        if($isAuthenticated==true)
        {
            if($accountStatus=='I' || $isPasswordExpired==true)
            {
                //Add your logic here

            }
            else
            {
                //Route the user to home page
                return $this->redirectToRoute('app_home_page');
            }
        }
        else
        {
            $authenticationUtils = $this->get('security.authentication_utils');

            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();

            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();

            $form = $this->createForm(LoginForm::class,[
                '_username'=>$lastUsername //if you fail to login pre-populate username
            ], [
                    'action' => $this->generateUrl('login_check')
                ]

            );

            $formTemplate = 'user.accounts/login';
        }

        return $this->render(
            'main/homepage.html.twig',
            array(
                // last username entered by the user
                'form' => $form->createView(),
                'error' => $error,
                'section' =>'outer',
                'formTemplate' =>$formTemplate,
                'title' =>'Homepage'
            )
        );

    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
       return $this->redirectToRoute('security_login');
    }


    /**
     * @Route("/token-authentication/reset-password", name="security_password_reset")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resetPasswordAction(Request $request)
    {
        $user=$this->getUser();
        $form = $this->createForm(ResetPasswordForm::class,$user, ['action' => $this->generateUrl('security_password_reset')]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $confirmPassword = $form['plainPasswordConfirm']->getData();
            $canChange = true;



            /*if($canChange === false)
                return $this->redirectToRoute('security_password_reset');
            */

        }
        return $this->render(
            'main/homepage.html.twig',
            array(
                // last username entered by the user
                'form' => $form->createView(),
                'error'=>null,
                'section' =>'outer',
                'formTemplate'=>'user.accounts/reset.password'
            )
        );

    }


    /**
     * @Route("/token-authentication/{token}", name="token_authentication")
     */
    public function authenticationCheckAction()
    {

        return $this->redirectToRoute('security_password_reset');
    }


    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        throw new \Exception('This should not be reached');

    }



}