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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');
            $table->string('service_name');
            $table->string('consumer_name');
            $table->unsignedBigInteger('payment_method_id');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->string('payment_name', 20);
            $table->string('payment_number', 30)->nullable();
            $table->date('payment_at');
            $table->date('commission_at');
            $table->decimal('price', 8,2);
            $table->decimal('additional_price', 8,2)->default(0);
            $table->decimal('tax', 8,2)->default(0);
            $table->decimal('commission', 8,2);
            $table->decimal('discount', 8,2);
            $table->decimal('total', 8,2);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('admin_name');
            $table->unsignedBigInteger('talent_id');
            $table->string('talent_name');
            $table->string('talent_payment_method')->nullable();
            $table->string('talent_payment_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
