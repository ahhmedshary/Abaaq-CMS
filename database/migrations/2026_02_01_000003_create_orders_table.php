<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->text('shipping_address');
            $table->string('city')->nullable();
            $table->unsignedInteger('subtotal');
            $table->unsignedInteger('shipping_fee')->default(0);
            $table->unsignedInteger('total');
            $table->enum('payment_method', ['stripe', 'cod'])->default('cod');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('status', ['new', 'processing', 'shipped', 'delivered', 'cancelled'])->default('new');
            $table->string('stripe_session_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
