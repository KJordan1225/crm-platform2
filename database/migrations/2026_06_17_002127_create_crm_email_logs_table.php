<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crm_email_logs', function (Blueprint $table) {
            $table->id();

            $table->nullableMorphs('emailable');

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('to_email');
            $table->string('to_name')->nullable();
            $table->string('subject');
            $table->longText('body');
            $table->string('status')->default('Sent');
            $table->timestamp('sent_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crm_email_logs');
    }
};
