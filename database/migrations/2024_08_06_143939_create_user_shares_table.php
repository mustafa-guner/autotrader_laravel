<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSharesTable extends Migration
{
    public function up(): void
    {
        Schema::create('user_shares', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('symbol');
            $table->string('exchange');
            $table->integer('price');
            $table->integer('quantity');
            $table->enum('action_type', ['buy', 'sell']); // Enum for action type
            $table->unsignedBigInteger('bought_by')->nullable(); // User or AI who created the entry
            $table->unsignedBigInteger('sold_by')->nullable(); // User or AI who sold the shares
            $table->timestamps();
            $table->softDeletes();

            // Relations
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('bought_by')->references('id')->on('users');
            $table->foreign('sold_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_shares');
    }
}
