<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_applications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('dependants');
            $table->string('residential_address');
            $table->string('product');
            $table->string('currency');
            $table->string('id_type');
            $table->string('id_number');
            $table->string('issue_date');
            $table->string('expiry_date');
            $table->string('amount_due');
            $table->string('amount_paid')->default(0);
            $table->string('outstanding_amount')->default(0);
            $table->string('passport');
            $table->string('id_card');
            $table->string('status')->default(5);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_applications');
    }
};
