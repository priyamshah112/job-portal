<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecruiterPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruiter_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recruiter_id')->references('id')->on('users');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->foreignId('package_id')->references('id')->on('packages');
            $table->bigInteger('post_quota_used')->nullable();
            $table->enum('status', ['expired','active']);
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
        Schema::dropIfExists('recruiter_packages');
    }
}
