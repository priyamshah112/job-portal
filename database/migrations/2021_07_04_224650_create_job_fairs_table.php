<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobFairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_fairs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description');
            $table->string('img_name')->nullable();
            $table->string('img_path')->nullable();
            $table->string('organizer_name');
            $table->text('address');
            $table->string('mobile_number');
            $table->string('email');
            $table->enum('type', ['online', 'offline']);
            $table->enum('price', ['free', 'price']);
            $table->integer('number_of_days');
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->text('additional_info')->nullable();            
            $table->string('department_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_fairs');
    }
}
