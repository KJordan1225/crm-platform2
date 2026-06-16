<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->foreignId('sales_team_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->foreignId('sales_team_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->foreignId('sales_team_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
        });

        Schema::table('opportunities', function (Blueprint $table) {
            $table->foreignId('sales_team_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
        });

        Schema::table('crm_tasks', function (Blueprint $table) {
            $table->foreignId('sales_team_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('crm_tasks', function (Blueprint $table) {
            $table->dropConstrainedForeignId('sales_team_id');
        });

        Schema::table('opportunities', function (Blueprint $table) {
            $table->dropConstrainedForeignId('sales_team_id');
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->dropConstrainedForeignId('sales_team_id');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('sales_team_id');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('sales_team_id');
        });
    }
};
