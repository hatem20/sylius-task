<?php
/**
 * Created by PhpStorm.
 * User: hatem
 * Date: 6/12/18
 * Time: 6:40 PM
 */

namespace AppBundle\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;


final class AdminMenuListener
{
    /**
     * @param MenuBuilderEvent $event
     */
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $newSubmenu = $menu
            ->getChild('catalog');

        $options  = [
            'route' => 'app_admin_stockroom_index',
//            'routeParameters' => ['username' => 'ahmed']

        ];
        $newSubmenu
            ->addChild('stockrooms', $options)
            ->setAttribute('type', 'link')
            ->setLabelAttribute('icon', 'shopping bag')
            ->setLabelAttribute('color', 'blue')
            ->setLabel('stockrooms');
    }
}