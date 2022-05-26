<?php

namespace App\Menu;

use App\Entity\Hotel;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilder
{
    private $factory;
    private $entityManager;

    /**
     * Add any other dependency you need...
     */
    public function __construct(FactoryInterface $factory, EntityManagerInterface $entityManager)
    {
        $this->factory = $factory;
        $this->entityManager = $entityManager;
    }

    public function createMainMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Home', ['route' => 'home']);
        $menu->addChild('About us', ['route' => 'about']);
        $menu->addChild('Contact us', ['route' => 'app_contact_new']);
        $menu->addChild('Hotels', ['route' => 'app_hotel_index']);

        $hotels = $this->entityManager->getRepository(Hotel::class)->findAll();
        $menu['Hotels']->setChildrenAttribute('class', 'dropdown-menu');
        foreach($hotels as $hotel){
            $menu['Hotels']->addChild($hotel->getName(), ['route' => 'app_hotel_show', 'routeParameters' => ['id' => $hotel->getId()],])->setAttribute('class', 'dropdown-item');
        }

        foreach ($menu->getChildren() as $child) {
            $child->setLinkAttribute('class', count($child->getChildren()) > 0 ? 'nav-link dropdown-toggle' :'nav-link')
                ->setAttribute('class', count($child->getChildren()) > 0 ? 'nav-item dropdown mr-1' :  'nav-item mr-1');
        }


        $menu->setChildrenAttribute('class', 'navbar-nav');


        return $menu;
    }
}