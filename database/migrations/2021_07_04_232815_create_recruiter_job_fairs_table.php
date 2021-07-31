<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecruiterJobFairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruiter_job_fairs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recruiter_id')->references('id')->on('users');
            $table->foreignId('job_fair_id')->references('id')->on('job_fairs');
            $table->jsonb('job_ids');
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
        Schema::dropIfExists('recruiter_job_fairs');
    }
}
