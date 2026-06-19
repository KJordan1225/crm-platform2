<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crm_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->default('CRM Platform');
            $table->string('company_email')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_website')->nullable();
            $table->string('currency')->default('USD');
            $table->string('timezone')->default('America/New_York');
            $table->string('date_format')->default('m/d/Y');
            $table->text('company_address')->nullable();
            $table->text('quote_terms')->nullable();
            $table->text('invoice_terms')->nullable();
            $table->decimal('default_tax_percent', 5, 2)->default(0);
            $table->boolean('enable_email_notifications')->default(true);
            $table->boolean('enable_task_reminders')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crm_settings');
    }
};
