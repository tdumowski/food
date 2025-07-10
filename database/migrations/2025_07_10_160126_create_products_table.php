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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('menu_id');
            $table->string('code')->nullable();
            $table->string('qty')->nullable();
            $table->string('size')->nullable();
            $table->decimal('price', 6, 2)->nullable();
            $table->decimal('discount_price', 6, 2)->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('most_poppular')->nullable();
            $table->string('best_seller')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
