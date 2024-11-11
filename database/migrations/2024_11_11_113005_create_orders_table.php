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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Order ID, primary key.
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            // `client_id` refers to the `clients` table, when a client is deleted, all his orders will also be deleted.

            $table->text('description'); // Order description.
            $table->string('status')->default('pending'); // Order status, for example, "pending".
            $table->timestamps(); // `created_at` and `updated_at` fields.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
