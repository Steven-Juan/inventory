<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table): void {
            $table->id();
            $table->string('sku', 60)->unique();
            $table->string('name', 160);
            $table->string('category', 120)->nullable();
            $table->string('unit', 30)->default('pcs');
            $table->string('location', 120)->nullable();
            $table->integer('stock')->default(0);
            $table->integer('minimum_stock')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('stock_movements', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['masuk', 'keluar']);
            $table->integer('quantity');
            $table->string('reference', 120)->nullable();
            $table->text('description')->nullable();
            $table->string('created_by', 120)->nullable();
            $table->timestamps();
        });

        Schema::create('communication_messages', function (Blueprint $table): void {
            $table->id();
            $table->enum('type', ['pesan', 'notifikasi'])->default('pesan');
            $table->string('title', 160);
            $table->text('body');
            $table->string('sender', 120);
            $table->string('recipient', 120);
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('communication_messages');
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('items');
    }
};

