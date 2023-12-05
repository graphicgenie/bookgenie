<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('address');
            $table->string('postcode');
            $table->string('city');
            $table->string('country')->default('NL');
            $table->integer('vat_number')->nullable();
            $table->integer('coc_number')->nullable();
            $table->string('email')->nullable();
            $table->string('type');
            $table->string('iban');
            $table->string('iban_name');
            $table->boolean('vat_liable');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
