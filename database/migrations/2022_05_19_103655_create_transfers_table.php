<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->longText('file_name')->nullable();
            $table->boolean('protected')->nullable()->default(false);
            $table->string('password')->nullable();
            $table->string('sent_from')->nullable();
            $table->string('sent_to')->nullable();
            $table->string('message')->nullable();
            $table->string('transfer_id')->nullable();
            $table->longText('transfer_url')->nullable();
            $table->longText('object_key')->nullable();
            $table->integer('downloads')->nullable();
            $table->integer('views')->nullable();
            $table->string('file_ext')->nullable();
            $table->decimal('size', 25, 2)->nullable();
            $table->string('share_type')->comment('email|link')->nullable();
            $table->string('storage')->comment('local|aws|wasabi|gcp|storj')->nullable();
            $table->string('plan_type')->comment('free|paid')->default('free');
            $table->string('file_type')->comment('zip|document|image|media|other')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfers');
    }
};
