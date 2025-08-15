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
        Schema::create('mail_api_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies', 'id')->onDelete('cascade');
            $table->string('mailer')->nullable();
            $table->string('input_host')->nullable();
            $table->string('output_host')->nullable();
            $table->integer('input_port')->nullable();
            $table->integer('output_port')->nullable();
            $table->string('username')->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('encryption')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_api_infos');
    }
};
