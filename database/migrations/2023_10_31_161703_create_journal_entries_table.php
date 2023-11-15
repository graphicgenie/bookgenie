<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ledger_account_id');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->unsignedBigInteger('journal_id')->nullable();
            $table->text('description')->nullable();
            $table->float('debit')->nullable();
            $table->float('credit')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_entries');
    }
};
