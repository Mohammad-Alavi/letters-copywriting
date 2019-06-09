<?php

namespace Denora\Letterwriting\Components;

use Cms\Classes\CodeBase;
use Cms\Classes\ComponentBase;
use Denora\Letterwriting\Models\OrderRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use October\Rain\Support\Facades\Flash;

class NewOrder extends ComponentBase {

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
            'name'        => 'New Order',
            'description' => 'A form to create a new order by customer'
        ];
    }

    /**
     * Defines the properties used by this class.
     * This method should be used as an override in the extended class.
     */
    public function defineProperties() {
        return [
            'user_id' => [
                'title'             => 'User ID',
                'description'       => 'ID of the user (Admin, Writer, Customer, ...)',
                'default'           => 0,
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'Enter a valid number'
            ]
        ];
    }

    public function onRun() {
        $this->userId = $this->property('user_id');
    }

    public function onCreateOrder() {
        if ($this->getValidator()->fails()) {
            return Redirect::back()->withErrors($this->getValidator());
        }

        $description = Input::get('description');
        $language = Input::get('language');
        $isRush = Input::get('is_rush', 0);

        $this->repository->create(
            123,
            $description,
            $language,
            0.0,
            $isRush
        );

        Flash::success('New order has been created successfully');
        return Redirect::back();
    }

    private function getValidator() {
        return Validator::make(
            [
                'description' => Input::get('description')
            ],
            [
                'description' => 'required|min:10'
            ]
        );
    }

}
