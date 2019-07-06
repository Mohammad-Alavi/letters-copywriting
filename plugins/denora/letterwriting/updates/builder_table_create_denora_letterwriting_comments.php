<?php namespace Denora\Letterwriting\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenoraLetterwritingComments extends Migration
{
    public function up()
    {
        Schema::create('denora_letterwriting_comments', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('sender_id');
            $table->integer('order_id');
            $table->text('text');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denora_letterwriting_comments');
    }
}
