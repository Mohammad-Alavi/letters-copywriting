<?php

namespace Denora\Letterwriting\Components;

use Cms\Classes\ComponentBase;
use Denora\Letterwriting\Models\Order;
use Denora\Letterwriting\Models\OrderRepository;
use Illuminate\Support\Facades\Redirect;
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
            'author'   => 'Author',
            'admin'    => 'Admin',
        ];
    }

    public function init() {
        parent::init();

        $this->repository = new OrderRepository();

        $this->role = $this->property('role');

        $orderId = $this->property('order_id');
        $this->order = $this->repository->find($orderId);

    }

    /**
     * REMEMBER: This must be shown only to authors
     *
     * @return mixed
     */
    public function onDone(){
        //  TODO: Check if the user is an author
        $this->order->setStatusDone();
        return Redirect::back();
    }

    /**
     * REMEMBER: This must be shown only to admins
     *
     * @return mixed
     */
    public function onDeliver(){
        //  TODO: Check if the user is an admin
        $this->order->setStatusDelivered();
        return Redirect::back();
    }

    /**
     * REMEMBER: This must be shown only to admins
     *
     * @return mixed
     */
    public function onReject(){
        //  TODO: Check if the user is an admin
        $this->order->setStatusRejected();
        return Redirect::back();
    }

}
