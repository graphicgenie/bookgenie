<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->unsignedBigInteger('tax_id');
            $table->float('amount');
            $table->float('price');
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('ledger_account_id');
            $table->integer('row_order')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
