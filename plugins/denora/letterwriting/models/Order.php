<?php namespace Denora\Letterwriting\Models;

use Model;

class Order extends Model {
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var StatusRepository
     */
    private $statusRepository;

    /**
     * Constructor
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = []) {
        parent::__construct($attributes);

        $this->orderRepository = new OrderRepository();
        $this->statusRepository = new StatusRepository();

    }

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'denora_letterwriting_orders';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var array
     */
    public $hasMany = [
        'statuses' => 'Denora\Letterwriting\Models\Status'
    ];

    /**
     * @param int    $doerId
     * @param string $description
     */
    public function setStatusCreated(int $doerId, string $description = '') {
        $this->setNewStatus($doerId, Status::$CREATED, $description);
    }

    /**
     * @param int    $doerId
     * @param float  $price
     * @param string $description
     */
    public function setStatusPriced(int $doerId, $price, string $description = '') {
        $this->orderRepository->changePrice($this->id, $price);
        $this->setNewStatus($doerId, Status::$PRICED, $description);
    }

    /**
     * @param int    $doerId
     * @param string $description
     */
    public function setStatusPaid(int $doerId, string $description = '') {
        $this->setNewStatus($doerId, Status::$PAID, $description);
    }

    /**
     * @param int    $doerId
     * @param int    $authorId
     * @param string $description
     */
    public function setStatusAssigned(int $doerId, int $authorId, string $description = '') {
        $this->orderRepository->assignAuthor($this->id, $authorId);
        $this->setNewStatus($doerId, Status::$ASSIGNED, $description);
    }

    /**
     * @param int    $doerId
     * @param string $text
     * @param string $description
     */
    public function setStatusDone(int $doerId, string $text, string $description = '') {
        //  Check if the user is this order's author
        if ($doerId != $this->author_id) return;

        $this->orderRepository->setText($this->id, $text);
        $this->setNewStatus($doerId, Status::$DONE, $description);
    }

    /**
     * @param int    $doerId
     * @param string $description
     */
    public function setStatusRejected(int $doerId, string $description = '') {
        $this->setNewStatus($doerId, Status::$REJECTED, $description);
    }

    /**
     * @param int    $doerId
     * @param string $description
     */
    public function setStatusDelivered(int $doerId, string $description = '') {
        $this->setNewStatus($doerId, Status::$DELIVERED, $description);
    }

    /**
     * @param int    $doerId
     * @param string $label
     * @param string $description
     */
    private function setNewStatus(int $doerId, string $label, string $description) {
        $this->orderRepository->changeStatus($this->id, $label);
        $this->statusRepository->create($doerId, $this->id, $label, $description);
    }

}
