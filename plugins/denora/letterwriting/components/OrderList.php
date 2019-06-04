<?php

namespace Denora\Letterwriting\Components;

use Cms\Classes\ComponentBase;
use Denora\Letterwriting\Models\Order;
use Denora\Letterwriting\Models\OrderRepository;

class OrderList extends ComponentBase {

    /**
     * @var Order[]
     */
    public $orderList = [];

    /**
     * @var String
     */
    public $orderStatus;

    /**
     * @var String
     */
    public $userRole;

    /**
     * @var int
     */
    public $userId;
    /**
     * @var OrderRepository
     */
    private $repository;

    /**
     * Returns information about this component, including name and description.
     */
    public function componentDetails() {
        return [
            'name'        => 'Order List',
            'description' => 'List of all orders'
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
            'status'  => [
                'title'       => 'Status',
                'description' => 'Status of orders',
                'type'        => 'dropdown',
                'default'     => 'all',
            ],
            'user_id' => [
                'title'             => 'User ID',
                'description'       => 'ID of the user (Admin, Writer, Customer, ...)',
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

    /**
     * Returns dropdown options for 'status' property
     *
     * @return array
     */
    public function getStatusOptions() {
        return [
            'all'                    => 'All',
            'picked'                 => 'Picked by writer',
            'requested_for_delivery' => "Requested for delivery",
        ];
    }

    public function onRun() {
        $this->repository = new OrderRepository();

        $this->userRole = $this->property('role');
        $this->userId = $this->property('user_id');
        $this->orderStatus = $this->property('status');

        $this->orderList = $this->repository->all();
    }

}
