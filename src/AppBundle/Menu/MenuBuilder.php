<?php


namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class MenuBuilder
{

    private $factory;
   
    /**
     * @var Router
     */
    private $router;
    /**
     * @var TokenStorage
     */
    private $tokenStorage;
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     * @param Router $router
     * @param TokenStorage $tokenStorage
     * @param RequestStack $requestStack
     */
    public function __construct(FactoryInterface $factory, Router $router,TokenStorage $tokenStorage,RequestStack $requestStack)
    {
        $this->factory = $factory;
        $this->router = $router;

        $this->tokenStorage = $tokenStorage;
        $this->requestStack = $requestStack;
    }

    public function createMainMenu()
    {
        $menu = $this->factory->createItem('root');

        $user = $this->tokenStorage->getToken()->getUser();

        //Set the Parent Menu Root Item
        $root = $menu->getRoot();
        $root->setChildrenAttributes(array('id' => 'sidebar-menu'));

        $menu = $this->createAdminMenu($menu);


        return $menu;
    }

    public function createAdminMenu(ItemInterface $menu)
    {

        return $menu;
    }



    public function getParameter($name)
    {
        return $this->requestStack->getCurrentRequest()->get($name);
    }

    public function getCrudLinks($name)
    {
       return [
            'routes' => [
                        ['route' => $name.'_add'],
                        ['route' => $name.'_info'],
                        ['route' => $name.'_edit']
            ]
        ];

    }


}