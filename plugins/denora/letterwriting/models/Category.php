<?php namespace Denora\Letterwriting\Models;

use Model;

/**
 * Model
 */
class Category extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'denora_letterwriting_categories';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
