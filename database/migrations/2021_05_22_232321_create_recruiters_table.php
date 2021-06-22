<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecruitersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruiters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('company_name')->nullable();
            $table->longText('company_address')->nullable();
            $table->string('company_landline_1')->nullable();
            $table->string('company_landline_2')->nullable();
            $table->string('company_mobile_1')->nullable();
            $table->string('company_mobile_2')->nullable();
            $table->string('logo_name')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('industry_segment')->nullable();
            $table->string('industry_type')->nullable();
            $table->string('no_of_employees')->nullable();
            $table->string('annual_turnover')->nullable();
            $table->string('doc_name')->nullable();
            $table->string('doc_path')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
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
        Schema::dropIfExists('recruiters');
    }
}
