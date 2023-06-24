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
        Schema::create('product_billings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_management_id');
            $table->unsignedBigInteger('billing_management_id');
            $table->string('quantity')->nullable();
            $table->timestamps();

            $table->foreign('product_management_id')->references('id')->on('product_management')->onDelete('cascade');
            $table->foreign('billing_management_id')->references('id')->on('billing_managments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_billings');
    }
};
