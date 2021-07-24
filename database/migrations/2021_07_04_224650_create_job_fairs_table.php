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
            $table->text('address')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('email')->nullable();
            $table->enum('type', ['online', 'offline']);
            $table->enum('price', ['free', 'price']);
            $table->string('amount')->nullable();
            $table->integer('number_of_days')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('additional_info')->nullable();            
            $table->string('department_id');
            $table->enum('status',[0,1])->default(1);
            $table->enum('draft',[0,1])->default(1);
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
