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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique('code');
            $table->string('name')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('subdomain')->unique()->nullable();
            $table->text('logo')->unique()->nullable();
            $table->string('users_used')->nullable();
            $table->string('users_limit')->nullable();
            $table->string('mail_acc_used')->nullable();
            $table->string('mail_acc_limit')->nullable();
            $table->string('users_limit')->nullable();
            $table->string('storage_used')->nullable();
            $table->string('storage_limit')->nullable();
            $table->time('office_start')->nullable();
            $table->time('office_end')->nullable();
            $table->string('timezone')->nullable();
            $table->string('currency')->nullable();
            $table->tinyInteger('status')->unsigned()->nullable()->default(1)->comment('company status: 0=Blocked, 1=Active, 2=Suspended');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
