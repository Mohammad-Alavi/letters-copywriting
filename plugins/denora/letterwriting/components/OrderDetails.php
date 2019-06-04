<?php

namespace Denora\Letterwriting\Components;

use Cms\Classes\ComponentBase;
use Denora\Letterwriting\Models\Order;
use Denora\Letterwriting\Models\OrderRepository;
use PhpParser\Node\Scalar\String_;

class OrderDetails extends ComponentBase {

    /**
     * @var Order
     */
    public $order;

    /**
     * @var String
     */
    public $role;

    /**
     * @var OrderRepository
     */
    private $repository;

    /**
     * Returns information about this component, including name and description.
     */
    public function componentDetails() {
        return [
            'name'        => 'Order Details',
            'description' => 'Preview of an order'
        ];
    }

    /**
     * Defines the properties used by this class.
     * This method should be used as an override in the extended class.
     */
    public function defineProperties() {
        return [
            'role'     => [
                'title'       => 'Role',
                'description' => 'Component items change according to user\'s role',
                'type'        => 'dropdown',
                'default'     => 'customer',
            ],
            'order_id' => [
                'title'             => 'Order ID',
                'description'       => 'ID of the order',
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
        $this->repository = new OrderRepository();

        $this->role = $this->property('role');
        $orderId = $this->property('order_id');

        $this->order = $this->repository->find($orderId);
    }

}
