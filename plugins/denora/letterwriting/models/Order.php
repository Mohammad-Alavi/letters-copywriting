<?php namespace Denora\Letterwriting\Models;

use Illuminate\Support\Facades\Mail;
use Model;
use RainLab\User\Models\User;

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
        'statuses'     => 'Denora\Letterwriting\Models\Status',
        'comments'     => 'Denora\Letterwriting\Models\Comment',
        'transactions' => 'Denora\TapCompany\Models\Transaction',
    ];

    public function getCustomerAttribute() {
        return User::query()->where('id', $this->customer_id)->first();
    }

    public function getAuthorAttribute() {
        return User::query()->where('id', $this->author_id)->first();
    }

    /**
     * @return bool
     */
    public function isPaid() {
        foreach ($this->transactions as $transaction){
            if ($transaction->paid_at != null) return true;
        }
        return false;
    }

    /**
     * @param int    $doerId
     * @param string $description
     */
    public function setStatusCreated(int $doerId, string $description = '') {
        $this->setNewStatus($doerId, Status::$CREATED, $description);
        $this->notifyStatusChanged();
    }

    /**
     * @param int    $doerId
     * @param float  $price
     * @param string $description
     */
    public function setStatusPriced(int $doerId, $price, string $description = '') {
        $this->orderRepository->changePrice($this->id, $price);
        $this->setNewStatus($doerId, Status::$PRICED, $description);
        $this->notifyStatusChanged();
    }

    /**
     * @param int    $doerId
     * @param string $description
     */
    public function setStatusPaid(int $doerId, string $description = '') {
        $this->setNewStatus($doerId, Status::$PAID, $description);
        $this->notifyStatusChanged();
    }

    /**
     * @param int    $doerId
     * @param int    $authorId
     * @param string $description
     */
    public function setStatusAssigned(int $doerId, int $authorId, string $description = '') {
        $this->orderRepository->assignAuthor($this->id, $authorId);
        $this->setNewStatus($doerId, Status::$ASSIGNED, $description);
        $this->notifyStatusChanged();
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
        $this->notifyStatusChanged();
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

    private function notifyStatusChanged() {
        $vars = ['name' => $this->customer->name, 'status' => $this->status, 'order' => $this];

        Mail::send('denora.letterwriting::mail.message', $vars, function ($message) {

            $message->to($this->customer->email);
            $message->subject('Order Status Report - Letters Copywriting');

        });
    }

}
