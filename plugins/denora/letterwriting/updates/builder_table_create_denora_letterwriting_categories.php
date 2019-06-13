<?php namespace Denora\Letterwriting\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateDenoraLetterwritingCategories extends Migration
{
    public function up()
    {
        Schema::create('denora_letterwriting_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label')->unique();
            $table->string('description');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('denora_letterwriting_categories');
    }
}
