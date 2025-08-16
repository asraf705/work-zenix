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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies', 'id')->onDelete('cascade');
            $table->foreignId('client_id')->nullable()->constrained('guests','id')->onDelete('cascade');
            $table->string('invoice_number')->nullable()->comment('autoGenarate')->unique();
            $table->string('currency')->nullable();
            $table->decimal('amount',15,2)->nullable();
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('status')->nullable()->default('0')->comment('0: draft, 1:sent, 2:paid, 3:overdue , 4: cancelled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
