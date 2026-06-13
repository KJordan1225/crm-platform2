<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_book_entries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('price_book_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            $table->decimal('list_price', 12, 2)->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['price_book_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_book_entries');
    }
};
