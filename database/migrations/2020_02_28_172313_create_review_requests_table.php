<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('agent');
            $table->string('client_email');
            $table->string('client_name');
            $table->dateTime('email_sent')->nullable();
            $table->dateTime('email_opened')->nullable();
            $table->dateTime('link_clicked')->nullable();
            $table->dateTime('star_rating_completed')->nullable();
            $table->integer('star_rating')->nullable();
            $table->dateTime('feedback_completed')->nullable();
            $table->integer('feedback')->nullable();
            $table->dateTime('external_link_clicked')->nullable();
            $table->dateTime('external_review_completed')->nullable();
            $table->foreign('agent')->references('id')->on('users');
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
        Schema::dropIfExists('review_requests');
    }
}
