<?php

namespace Denora\Letterwriting\Components;

use Cms\Classes\CodeBase;
use Cms\Classes\ComponentBase;
use Denora\Letterwriting\Models\Category;
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
    public $orderCategory;

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

    public function __construct(CodeBase $cmsObject = null, $properties = []) {
        parent::__construct($cmsObject, $properties);

        $this->repository = new OrderRepository();
    }

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
            'role'     => [
                'title'       => 'Role',
                'description' => 'Component items change according to user\'s role',
                'type'        => 'dropdown',
                'default'     => 'customer',
            ],
            'status'   => [
                'title'       => 'Status',
                'description' => 'Status of orders',
                'type'        => 'dropdown',
                'default'     => 'all',
            ],
            'category' => [
                'title'       => 'Category',
                'description' => 'Category of orders',
                'type'        => 'dropdown',
                'default'     => 'all',
            ],
            'user_id'  => [
                'title'             => 'User ID',
                'description'       => 'ID of the user (Admin, Author, Customer, ...)',
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

    /**
     * Returns dropdown options for 'status' property
     *
     * @return array
     */
    public function getStatusOptions() {
        return [
            'all'             => 'All',
            'created'         => 'Waiting for pricing (created)',
            'priced'          => 'Waiting to be paid (priced)',
            'paid'            => 'Waiting to be assigned (paid)',
            'assigned'        => 'Waiting to be done (assigned)',
            'done'            => 'Waiting to be delivered (done)',
            'rejected'        => 'Waiting to be edited (rejected)',
            'delivered'       => 'Delivered to the customer (delivered)',
            'customer_prefer' => 'Customer Prefer [CREATED, PRICED, PAID, ASSIGNED, DONE, REJECTED]',
        ];
    }

    /**
     * Returns dropdown options for 'category' property
     *
     * @return array
     */
    public function getCategoryOptions() {
        $categoryList = Category::all();
        $categoryArray['all'] = 'All';
        foreach ($categoryList as $category) {
            $categoryArray[$category['label']] = $category['label'];
        }

        return $categoryArray;
    }

    public function onRender() {
        parent::onRender();

        $this->userRole = $this->property('role');
        $this->userId = $this->property('user_id');
        $this->orderStatus = $this->property('status');
        $this->orderCategory = $this->property('category');

        $this->orderList = $this->repository->paginate($this->orderStatus, $this->orderCategory, $this->userRole, $this->userId);
    }

}
