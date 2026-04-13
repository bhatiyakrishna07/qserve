<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);        // e.g. Table 1, Table 2
            $table->integer('capacity');         // how many people
            $table->string('qr_code', 191)->nullable();  // qr code image path
            $table->enum('status', ['available', 'occupied'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};