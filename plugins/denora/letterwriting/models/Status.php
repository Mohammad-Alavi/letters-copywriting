<?php namespace Denora\Letterwriting\Models;

use Model;

/**
 * Model
 */
class Status extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


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
