<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Allergenen', function (Blueprint $table) {
            $table->id('Id');
            $table->string('Naam', 100);
            $table->string('Omschrijving', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Allergenen');
    }
};
