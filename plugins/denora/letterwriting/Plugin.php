<?php namespace Denora\Letterwriting;

use Denora\Letterwriting\Models\Settings;
use RainLab\User\Models\User;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Denora\Letterwriting\Components\OrderList' => 'orderList',
            'Denora\Letterwriting\Components\OrderDetails' => 'orderDetails',
            'Denora\Letterwriting\Components\OrderHistory' => 'orderHistory',
            'Denora\Letterwriting\Components\NewOrder' => 'newOrder',
            'Denora\Letterwriting\Components\AuthorAssignment' => 'authorAssignment',
            'Denora\Letterwriting\Components\CommentList' => 'commentList',
        ];
    }

    /**
     * Registers any back-end configuration links used by this plugin.
     *
     * @return array
     */
    public function registerSettings()
    {
        return [
            'order' => [
                'label' => 'Order',
                'description' => 'Settings related to order system.',
                'category' => 'Letter Writing',
                'icon' => 'icon-shopping-basket',
                'class' => 'Denora\Letterwriting\Models\Settings',
                'order' => 500,
                'keywords' => 'order rush'
            ],
        ];
    }

    public function registerMarkupTags()
    {
        return [
            'functions' => [
                'isRushEnabled' => function () {
                    return Settings::instance()->rush_enabled;
                },
                'getRushPercentage' => function () {
                    return Settings::instance()->rush_percentage;
                },
                'isAdmin' => function (int $userId) {
                    return $this->checkUserRole($userId, 'admin');
                },
                'isAuthor' => function (int $userId) {
                    return $this->checkUserRole($userId, 'author');
                },
                'isCustomer' => function (int $userId) {
                    return $this->checkUserRole($userId, 'customer');
                }
            ]
        ];
    }

    private function checkUserRole(int $userId, string $userRole)
    {
        $user = User::find($userId);
        $groups = $user->groups;
        foreach ($groups as $group)
            if ($group->code == $userRole) return true;

        return false;
    }
}
