<?php namespace Denora\TapCompany\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenoraTapcompanyTransactions extends Migration
{
    public function up()
    {
        Schema::create('denora_tapcompany_transactions', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('order_id');
            $table->string('charge_id')->unique();
            $table->text('payment_url');
            $table->text('description')->nullable();

            $table->timestamp('paid_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denora_tapcompany_transactions');
    }
}
