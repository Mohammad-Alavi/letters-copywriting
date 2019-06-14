<?php namespace Denora\Letterwriting\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenoraLetterwritingStatuses extends Migration
{
    public function up()
    {
        Schema::create('denora_letterwriting_statuses', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('doer_id');
            $table->integer('order_id');
            $table->string('label');
            $table->text('description');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denora_letterwriting_statuses');
    }
}
