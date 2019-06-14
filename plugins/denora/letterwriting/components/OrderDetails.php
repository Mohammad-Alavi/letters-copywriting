<?php

namespace Denora\Letterwriting\Components;

use Cms\Classes\CodeBase;
use Cms\Classes\ComponentBase;
use Denora\Letterwriting\Models\Order;
use Denora\Letterwriting\Models\OrderRepository;
use Illuminate\Support\Facades\Redirect;

class OrderDetails extends ComponentBase {

    /**
     * @var Order
     */
    public $order;

    /**
     * @var int
     */
    public $userId;

    /**
     * @var String
     */
    public $userRole;

    /**
     * @var OrderRepository
     */
    private $repository;

    /**
     * Component constructor. Takes in the page or layout code section object
     * and properties set by the page or layout.
     *
     * @param null|CodeBase $cmsObject
     * @param array         $properties
     */
    public function __construct(CodeBase $cmsObject = null, $properties = []) {
        parent::__construct($cmsObject, $properties);

        $this->repository = new OrderRepository();
    }

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
            'user_id'   => [
                'title'             => 'User ID',
                'description'       => 'ID of the user (Admin, Writer, Customer, ...)',
                'default'           => 0,
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'Enter a valid number'
            ],
            'role' => [
                'title'       => 'User Role',
                'description' => 'Component items change according to user\'s role',
                'type'        => 'dropdown',
                'default'     => 'customer',
            ],
            'order_id'  => [
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

        $this->userId = $this->property('user_id');
        $this->userRole = $this->property('role');

        $orderId = $this->property('order_id');
        $this->order = $this->getOrder($orderId);
    }

    /**
     * @param int $orderId
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getOrder(int $orderId) {
        return $this->repository->find($orderId);
    }

    /**
     * REMEMBER: This must be shown only to authors
     *
     * @return mixed
     */
    public function onDone() {
        //  TODO: Check if the user is an author
        $this->order->setStatusDone($this->userId);

        return Redirect::back();
    }

    /**
     * REMEMBER: This must be shown only to admins
     *
     * @return mixed
     */
    public function onDeliver() {
        //  TODO: Check if the user is an admin
        $this->order->setStatusDelivered($this->userId);

        return Redirect::back();
    }

    /**
     * REMEMBER: This must be shown only to admins
     *
     * @return mixed
     */
    public function onReject() {
        //  TODO: Check if the user is an admin
        $this->order->setStatusRejected($this->userId);

        return Redirect::back();
    }

}
