<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('transaction_type_id');
            $table->unsignedBigInteger('transaction_status_id');
            $table->unsignedBigInteger('user_id');
            $table->string('amount');
            $table->string('currency');
            $table->unsignedBigInteger('transaction_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Relations
            $table->foreign('transaction_by')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('transaction_type_id')->references('id')->on('transaction_types');
            $table->foreign('transaction_status_id')->references('id')->on('transaction_statuses');
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
