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
        Schema::create('pay_slips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies', 'id')->onDelete('cascade');
            $table->foreignId('employ_id')->nullable()->constrained('employees','id')->onDelete('cascade');
            $table->string('type')->nullable()->comment('cash,bank,mobileBank');
            $table->string('tnx_id')->nullable();
            $table->year('month')->nullable();
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->decimal('basic_salary', 10, 2)->nullable();
            $table->decimal('allowances', 10, 2)->nullable();
            $table->decimal('deductions', 10, 2)->nullable();
            $table->decimal('net_salary', 10, 2)->nullable();
            $table->date('payment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_slips');
    }
};
