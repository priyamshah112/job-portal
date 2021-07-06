<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recruiter_id');
            $table->foreign('recruiter_id')->references('id')->on('users');
            $table->string('position')->nullable();
            $table->longText('description')->nullable();
            $table->integer('num_position')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->integer('age_min')->nullable();
            $table->integer('age_max')->nullable();
            $table->string('gender')->nullable();
            $table->json('qualification_id')->nullable();
            $table->integer('experience')->nullable();
            $table->integer('maxexperience')->nullable();
            $table->bigInteger('salary_min')->nullable();
            $table->bigInteger('salary_max')->nullable();
            $table->json('skills')->nullable();
            $table->enum('status',array('0','1'))->nullable();
            $table->date('deadline')->nullable();
            $table->enum('draft',array('0','1'))->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
