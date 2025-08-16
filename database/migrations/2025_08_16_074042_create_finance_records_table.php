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
        Schema::create('finance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies', 'id')->onDelete('cascade');
            $table->foreignId('employ_id')->nullable()->constrained('employees','id')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('finance_categories','id')->onDelete('cascade');
            $table->foreignId('project_id')->nullable()->constrained('projects','id')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->enm('type',['income','expense','transfer'])->nullable();
            $table->string('currency')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_records');
    }
};
