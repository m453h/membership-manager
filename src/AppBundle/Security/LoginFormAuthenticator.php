<?php


namespace AppBundle\Security;


use AppBundle\Form\Accounts\LoginForm;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{

    private $formFactory;
    private $em;
    private $router;
    private $passwordEncoder;

    public function __construct(FormFactoryInterface $formFactory, EntityManager $em, RouterInterface $router,UserPasswordEncoder $passwordEncoder)
    {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
    }


    public function getCredentials(Request $request)
    {
        $isLoginSubmit = $request->getPathInfo() == '/login_check' && $request->isMethod('POST');

        if(!$isLoginSubmit){
            return null; 
        }

        $form = $this->formFactory->create(LoginForm::class);

        $form->handleRequest($request);

        $data =$form->getData();

        if(empty($data['_username']) || empty($data['_password']))
            throw new CustomUserMessageAuthenticationException(
                'Please provide all the required information'
            );


        $request->getSession()->set(
            Security::LAST_USERNAME,
            $data['_username']
        );

        return $data;

    }


    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['_username'];

        return $this->em->getRepository('AppBundle:UserAccounts\User')
            ->findOneBy(['username'=>$username]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
       $password = $credentials['_password'];

        if ($this->passwordEncoder->isPasswordValid($user, $password)) {
            return true; 
        }

        return false;
    }
    
    protected function getLoginUrl()
    {
        return $this->router->generate('security_login');
    }

    protected function getDefaultSuccessRedirectUrl()
    {
       return $this->router->generate('app_home_page');
    }

}