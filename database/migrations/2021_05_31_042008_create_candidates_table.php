<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->longText('about')->nullable();
            $table->foreignId('qualification_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->json('skills')->nullable();
            $table->date('dateOfBirth')->nullable();
            $table->string('gender')->nullable();
            $table->string('alt_email')->unique()->nullable();
            $table->string('alt_mobile_number')->nullable();
            $table->longText('permanent_address')->nullable();
            $table->string('category')->nullable();
            $table->string('department_id')->nullable();
            $table->string('specialization')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->jsonb('preferred_state')->nullable();
            $table->jsonb('preferred_city')->nullable();
            $table->string('resume_name')->nullable();
            $table->string('resume_path')->nullable();
            $table->string('video_resume_name')->nullable();
            $table->string('video_resume_path')->nullable();
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
        Schema::dropIfExists('candidates');
    }
}
