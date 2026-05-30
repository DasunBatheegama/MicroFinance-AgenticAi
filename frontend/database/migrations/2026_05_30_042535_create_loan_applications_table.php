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
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable(); // Assuming nullable for demo if users aren't loaded yet
            $table->decimal('amount', 15, 2);
            $table->string('purpose');
            $table->integer('term_months');
            $table->string('status')->default('Pending');
            $table->json('cashflow_data')->nullable();
            $table->text('credit_memo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_applications');
    }
};
