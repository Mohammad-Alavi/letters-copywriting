<?php namespace Denora\Letterwriting\Models;

use Model;

class Order extends Model {
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;

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

    public function getStatusAttribute(){
        return $this->statuses->last();
    }

    /**
     * @param string $description
     */
    public function setStatusCreated(string $description = ''){
        $this->setNewStatus(Status::$CREATED, $description);
    }

    /**
     * @param string $description
     */
    public function setStatusPaid(string $description = ''){
        $this->setNewStatus(Status::$PAID, $description);
    }

    /**
     * @param string $description
     */
    public function setStatusPicked(string $description = ''){
        $this->setNewStatus(Status::$PICKED, $description);
    }

    /**
     * @param string $description
     */
    public function setStatusDone(string $description = ''){
        $this->setNewStatus(Status::$DONE, $description);
    }

    /**
     * @param string $description
     */
    public function setStatusRejected(string $description = ''){
        $this->setNewStatus(Status::$REJECTED, $description);
    }

    /**
     * @param string $description
     */
    public function setStatusDelivered(string $description = ''){
        $this->setNewStatus(Status::$DELIVERED, $description);
    }

    /**
     * @param string $label
     * @param string $description
     */
    private function setNewStatus(string $label, string $description) {
        $repository = new StatusRepository();

        $repository->create($this->id, $label, $description);
    }

}
