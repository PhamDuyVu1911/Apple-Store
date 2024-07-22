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
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('description');
            $table->string('content');
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->boolean('hot')->default(false);
            $table->integer('view_count')->default(0);
            $table->string('brand')->default('Apple');
            $table->string('img');
            $table->string('color');
            $table->foreignId('category_id')->constrained('categories');
            $table->boolean('delete')->default(false);
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
