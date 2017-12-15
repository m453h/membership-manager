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
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;

    }

    public function createMainMenu()
    {
        $menu = $this->factory->createItem('root');

        //Set the Parent Menu Root Item
        $root = $menu->getRoot();
        $root->setChildrenAttributes(array('id' => 'sidebar-menu'));

        $menu->addChild('Configuration', array('uri' => '#', 'extras' => array('icon' => 'wrench')))

            ->addChild('Manage Benefit Types', array('route' => 'list_benefit', 'extras' => []))
                ->addChild('Add Benefit Type', array('route' => 'add_benefit', 'extras' => []))->setDisplay(false)
                ->getParent()
                ->addChild('Edit Benefit Type', array('route' => 'edit_benefit', 'extras' => []))->setDisplay(false)
                ->getParent()
            ->getParent()

            ->addChild('Manage Members Types', array('route' => 'list_member', 'extras' => []))
                ->addChild('Add Member', array('route' => 'add_member', 'extras' => []))->setDisplay(false)
                ->getParent()
                ->addChild('Edit Member', array('route' => 'edit_benefit', 'extras' => []))->setDisplay(false)
                ->getParent()
            ->getParent()

            ->addChild('Manage Beneficiary Types', array('route' => 'list_beneficiary', 'extras' => []))
            ->addChild('Edit Beneficiary', array('route' => 'edit_beneficiary', 'extras' => []))->setDisplay(false)
            ->getParent()
            ->getParent()

        ->getParent();


        return $menu;
    }


}