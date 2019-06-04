<?php

namespace Denora\Letterwriting\Components;

use Cms\Classes\ComponentBase;
use Denora\Letterwriting\Models\OrderRepository;
use Denora\Letterwriting\Models\Status;

class OrderHistory extends ComponentBase {

    /**
     * @var Status[]
     */
    public $statusList = [];

    /**
     * @var String
     */
    public $userRole;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * Returns information about this component, including name and description.
     */
    public function componentDetails() {
        return [
            'name'        => 'Order History',
            'description' => 'List of order statuses'
        ];
    }

    /**
     * Defines the properties used by this class.
     * This method should be used as an override in the extended class.
     */
    public function defineProperties() {
        return [
            'role'    => [
                'title'       => 'Role',
                'description' => 'Component items change according to user\'s role',
                'type'        => 'dropdown',
                'default'     => 'customer',
            ],
            'order_id' => [
                'title'             => 'Order ID',
                'description'       => 'ID of the Order',
                'default'           => 0,
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'Enter a valid number'
            ]
        ];
    }

    /**
     * Returns dropdown options for 'role' property
     *
     * @return array
     */
    public function getRoleOptions() {
        return [
            'customer' => 'Customer',
            'writer'   => 'Writer',
            'admin'    => 'Admin',
        ];
    }

    public function onRun() {
        $this->orderRepository = new OrderRepository();

        $this->userRole = $this->property('role');
        $orderId = $this->property('order_id');

        $this->statusList = $this->orderRepository->find($orderId)->statuses;
    }

}
