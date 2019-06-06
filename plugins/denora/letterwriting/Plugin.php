<?php namespace Denora\Letterwriting;

use System\Classes\PluginBase;

class Plugin extends PluginBase {

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents() {
        return [
            'Denora\Letterwriting\Components\OrderList'    => 'orderList',
            'Denora\Letterwriting\Components\OrderDetails' => 'orderDetails',
            'Denora\Letterwriting\Components\OrderHistory' => 'orderHistory',
            'Denora\Letterwriting\Components\NewOrder'     => 'newOrder',
        ];
    }

    /**
     * Registers any back-end configuration links used by this plugin.
     *
     * @return array
     */
    public function registerSettings() {

    }
}
