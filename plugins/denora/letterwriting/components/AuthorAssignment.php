<?php

namespace Denora\Letterwriting\Components;

use Cms\Classes\CodeBase;
use Cms\Classes\ComponentBase;
use Denora\Letterwriting\Models\Category;
use Denora\Letterwriting\Models\Order;
use Denora\Letterwriting\Models\OrderRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use October\Rain\Support\Facades\Flash;
use RainLab\User\Models\User;
use RainLab\User\Models\UserGroup;

class AuthorAssignment extends ComponentBase {

    /**
     * @var Order
     */
    public $order;

    /**
     * @var int
     */
    public $adminId;

    /**
     * @var User[]
     */
    public $authorList;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(CodeBase $cmsObject = null, $properties = []) {
        parent::__construct($cmsObject, $properties);

        $this->orderRepository = new OrderRepository();
    }


    /**
     * Returns information about this component, including name and description.
     */
    public function componentDetails() {
        return [
            'name'        => 'Author Assignment',
            'description' => 'A form assign an author to an order'
        ];
    }

    /**
     * Defines the properties used by this class.
     * This method should be used as an override in the extended class.
     */
    public function defineProperties() {
        return [
            'admin_id' => [
                'title'             => 'Admin ID',
                'description'       => 'ID of the Admin',
                'default'           => 0,
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'Enter a valid number'
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

    public function init() {
        $this->adminId = $this->property('admin_id');

        $orderId = $this->property('order_id');
        $this->order = $this->orderRepository->find($orderId);

        $this->authorList = User::whereHas('groups', function ($query) {
            $query->where('code', '=', 'author');
        })->get();
    }

    /**
     * REMEMBER: This must be shown only to admin
     *
     * @return mixed
     */
    public function onAssignAuthor(){
<<<<<<< HEAD
        //  TODO: Check if the user is an admin.
        $authorId = Input::get('author_id');
=======
        //  TODO: Check if the user is an admin
        $authorId = (int)Input::get('author_id');
>>>>>>> 8669775b5f8c99efe995d640952dc83391389198
        $this->order->setStatusAssigned($this->adminId, $authorId);
        return Redirect::back();
    }

}
