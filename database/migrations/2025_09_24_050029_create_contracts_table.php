<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('rent_amount', 10, 2);
            $table->decimal('security_deposit', 10, 2)->nullable();
            $table->enum('contract_type', [ 'short_term', 'long_term', 'monthly'])->default('monthly');
            $table->enum('status', [ 'draft', 'active', 'terminated', 'expired'])->default('draft');
            $table->text('terms_conditions')->nullable();
            $table->string('contract_file_path')->nullable();
            $table->timestamp('signed_at')->nullable();
            $table->timestamps();

            // indexes for faster query
            $table->index(['property_id', 'status']);
            $table->index(['user_id', 'status']);
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
