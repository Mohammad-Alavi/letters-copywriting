<?php namespace Denora\Letterwriting;

use Denora\Letterwriting\Models\Settings;
use System\Classes\PluginBase;

class Plugin extends PluginBase {

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents() {
        return [
            'Denora\Letterwriting\Components\OrderList'        => 'orderList',
            'Denora\Letterwriting\Components\OrderDetails'     => 'orderDetails',
            'Denora\Letterwriting\Components\OrderHistory'     => 'orderHistory',
            'Denora\Letterwriting\Components\NewOrder'         => 'newOrder',
            'Denora\Letterwriting\Components\AuthorAssignment' => 'authorAssignment',
            'Denora\Letterwriting\Components\CommentList'      => 'commentList',
        ];
    }

    /**
     * Registers any back-end configuration links used by this plugin.
     *
     * @return array
     */
    public function registerSettings() {
        return [
            'rush' => [
                'label'       => 'Rush',
                'description' => 'Change how rush system works.',
                'category'    => 'Letter Writing',
                'icon'        => 'icon-car',
                'class'       => 'Denora\Letterwriting\Models\Settings',
                'order'       => 500,
                'keywords'    => 'rush order'
            ]
        ];
    }

    public function registerMarkupTags() {
        return [
            'functions' => [
                'getRushPercentage' => function () {
                    return Settings::instance()->rush_percentage;
                }
            ]
        ];
    }
}
