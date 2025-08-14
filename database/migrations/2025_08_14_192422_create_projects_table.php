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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained(table: 'companies')->onDelete('cascade');
            $table->foreignId('client_id')->nullable()->constrained(table:'guests')->onDelete('cascade');
            $table->string('naem')->nullable();
            $table->text('description')->nullable();
            $table->string('live_url')->nullable();
            $table->decimal('totel_price',10,2)->nullable();
            $table->decimal('payment',10,2)->nullable();
            $table->decimal('due',10,2)->nullable();
            $table->tinyInteger('status')->default(0)->comment('0:pandding, 1:active, 2:completed, 3:deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
