<?php

namespace Denora\Letterwriting\Components;

use Cms\Classes\CodeBase;
use Cms\Classes\ComponentBase;
use Denora\Letterwriting\Models\Comment;
use Denora\Letterwriting\Models\CommentRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use October\Rain\Support\Facades\Flash;

class CommentList extends ComponentBase {

    /**
     * @var int
     */
    public $userId;

    /**
     * @var int
     */
    public $orderId;

    /**
     * @var Comment[]
     */
    public $commentList;

    /**
     * @var CommentRepository
     */
    private $commentRepository;

    public function __construct(CodeBase $cmsObject = null, $properties = []) {
        parent::__construct($cmsObject, $properties);

        $this->commentRepository = new CommentRepository();
    }

    /**
     * Returns information about this component, including name and description.
     */
    public function componentDetails() {
        return [
            'name'        => 'Comment List',
            'description' => 'List of an order\'s comments'
        ];
    }

    /**
     * Defines the properties used by this class.
     * This method should be used as an override in the extended class.
     */
    public function defineProperties() {
        return [
            'user_id'  => [
                'title'             => 'User ID',
                'description'       => 'ID of the user (Admin, Writer, Customer, ...)',
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
        $this->userId = $this->property('user_id');
        $this->orderId = $this->property('order_id');
        $this->commentList = $this->commentRepository->all($this->orderId);
    }

    public function onCreateComment() {
        if ($this->getValidator()->fails()) {
            return Redirect::back()->withErrors($this->getValidator());
        }

        $text = Input::get('text');

        $this->commentRepository->create(
            $this->userId,
            $this->orderId,
            $text
        );

        Flash::success('New Comment has been created successfully');

        return Redirect::back();
    }

    private function getValidator() {
        return Validator::make(
            [
                'text' => Input::get('text')
            ],
            [
                'text' => 'required|min:2'
            ]
        );
    }

}
