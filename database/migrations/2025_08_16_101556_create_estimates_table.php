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
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies', 'id')->onDelete('cascade');
            $table->foreignId('client_id')->nullable()->constrained('guests','id')->onDelete('cascade');
            $table->string('reference_number')->nullable()->comment('Estimates & Quotations Reference Number');
            $table->decimal('total_amount',15,2)->nullable();
            $table->date('issue_date')->nullable();
            $table->date('valid_until')->nullable();
            $table->string('status')->default('0')->comment('0:draft, 1:sent, 2:accepted, 3:rejected');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimates');
    }
};
