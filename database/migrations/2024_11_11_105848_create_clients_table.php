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
        Schema::create('clients', function (Blueprint $table) {
            $table->id(); //The client ID, the primary key, will be generated automatically.
            $table->string('first_name'); //Client name, data type — string (up to 255 characters).
            $table->string('last_name'); // Customer's last name.
            $table->string('email')->unique(); // Client email, unique.
            $table->string('phone')->unique(); // Customer phone number, unique.
            $table->timestamps(); // The fields `created_at` and `updated_at` will be automatically created.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
