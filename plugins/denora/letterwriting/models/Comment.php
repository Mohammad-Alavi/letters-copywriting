<?php namespace Denora\Letterwriting\Models;

use Model;
use RainLab\User\Models\User;

/**
 * Model
 */
class Comment extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'denora_letterwriting_comments';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'order' => 'Denora\Letterwriting\Models\Order'
    ];
    
    public function getSenderAttribute() {
        return User::query()->where('id', $this->sender_id)->first();
    }
}
