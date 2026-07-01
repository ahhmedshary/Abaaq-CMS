<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('price');         // stored in halalas/cents
            $table->unsignedInteger('compare_price')->nullable(); // for "was" price / discount
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->unsignedInteger('stock')->default(100);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_on_offer')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
