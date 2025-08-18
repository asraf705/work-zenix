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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies', 'id')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->foreignId('role_id')->nullable()->constrained('roles', 'id')->onDelete('cascade');
            $table->date('joining_date')->nullable()->comment('Date when employee joined the company');
            $table->date('resign_date')->nullable()->comment('Date when employee resigned from the company');
            $table->decimal('monthly_salary',10,2)->nullable();
            $table->decimal('overtime_hourly',10,2)->nullable();
            // Fields for fingerprint and face recognition
            $table->string('fingerprint_data')->nullable()->comment('Base64 encoded fingerprint data');
            $table->string('face_data')->nullable()->comment('Base64 encoded facial recognition data');
            // Fields for Joiend
            $table->text('cv_url')->nullable()->comment('cv Document');
            $table->text('veryfy_url')->nullable()->comment('Verification Document');
            // Fields for self info
            $table->text('image')->nullable()->comment('Employer Image');
            $table->string('fathers_name')->nullable()->comment('Fathers Name');
            $table->string('mothers_name')->nullable()->comment('Mothers Name');
            $table->string('marital_status')->nullable()->comment('Marital Status');
            $table->string('nationality')->nullable()->comment('Nationality');
            $table->string('religion')->nullable()->comment('Religion');
            $table->string('blood_group')->nullable()->comment('Blood Group');
            $table->string('emergency_contact_name')->nullable()->comment('Emergency Contact Name');
            //auth for emply
            $table->string('user_ip')->nullable();
            $table->string('device_fingerprint')->nullable();
            $table->string('is_active')->default(0)->comment('1:actv , 0:inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
