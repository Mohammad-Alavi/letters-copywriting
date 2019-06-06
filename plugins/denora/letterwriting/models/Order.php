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

    /**
     * @param string $label
     * @param string $description
     */
    public function setNewStatus(string $label, string $description = '') {
        $repository = new StatusRepository();

        $repository->create($this->id, $label, $description);
    }

}
