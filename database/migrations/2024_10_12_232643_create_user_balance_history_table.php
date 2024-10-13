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
        Schema::create('user_balance_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_balance_id');
            $table->string('amount');
            $table->string('currency');
            $table->unsignedBigInteger('bank_account_id')->nullable();
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->unsignedBigInteger('transaction_type_id');
            $table->timestamps();
            $table->softDeletes();

            // Relations
            $table->foreign('user_balance_id')->references('id')->on('user_balances');
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->foreign('transaction_type_id')->references('id')->on('transaction_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_balance_history');
    }
};
