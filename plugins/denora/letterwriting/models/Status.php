<?php namespace Denora\Letterwriting\Models;

use Model;

/**
 * Model
 */
class Status extends Model {
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    static $CREATED   = 'created';  //  Is done by customer
    static $PRICED    = 'priced';  //  Is done by admin
    static $PAID      = 'paid';  //  Is done by customer
    static $ASSIGNED  = 'assigned';  //  Is done by admin
    static $DONE      = 'done';  //  Is done by author
    static $REJECTED  = 'rejected';  //  Is done by admin
    static $DELIVERED = 'delivered';  //  Is done by admin

    /**
     * @var string The database table used by the model.
     */
    public $table = 'denora_letterwriting_statuses';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'order' => 'Denora\Letterwriting\Models\Order'
    ];

}
