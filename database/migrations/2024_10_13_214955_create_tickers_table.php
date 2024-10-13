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
        Schema::create('tickers', function (Blueprint $table) {
            $table->id();
            $table->string('ticker')->unique();
            $table->string('name')->nullable();
            $table->string('market')->nullable();
            $table->string('locale')->nullable();
            $table->string('primary_exchange')->nullable();
            $table->string('type')->nullable();
            $table->boolean('active')->nullable();
            $table->string('currency_name')->nullable();
            $table->string('cik')->nullable();
            $table->string('composite_figi')->nullable();
            $table->string('share_class_figi')->nullable();
            $table->bigInteger('market_cap')->nullable();
            $table->string('phone_number')->nullable();

            // Address fields
            $table->string('address1')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();

            // Additional fields
            $table->text('description')->nullable();
            $table->string('sic_code')->nullable();
            $table->string('sic_description')->nullable();
            $table->string('ticker_root')->nullable();
            $table->string('homepage_url')->nullable();
            $table->integer('total_employees')->nullable();
            $table->date('list_date')->nullable();

            // Branding URLs
            $table->string('logo_url')->nullable();
            $table->string('icon_url')->nullable();

            // Shares
            $table->bigInteger('share_class_shares_outstanding')->nullable();
            $table->bigInteger('weighted_shares_outstanding')->nullable();
            $table->integer('round_lot')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticker_details');
    }
};
