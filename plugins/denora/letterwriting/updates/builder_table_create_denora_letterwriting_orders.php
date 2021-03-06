<?php namespace Denora\Letterwriting\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenoraLetterwritingOrders extends Migration
{
    public function up()
    {
        Schema::create('denora_letterwriting_orders', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('customer_id');
            $table->integer('author_id')->nullable();
            $table->text('description');
            $table->text('text')->nullable();
            $table->boolean('is_rush')->default(0);
            $table->string('language');
            $table->string('category');
            $table->double('price')->nullable();
            $table->string('status')->default('created');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denora_letterwriting_orders');
    }
}
