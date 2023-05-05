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
        Schema::create('product_statuses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('package_category_id')->unsigned();
            $table->string('name');
            $table->integer('percent');
            $table->integer('priority');
            $table->integer('tat');
            $table->boolean('send_notification')->default(false);
            $table->timestamps();

            $table->foreign('package_category_id')->references('id')->on('package_categories')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_statuses');
    }
};
