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
        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('type', ['topup', 'payment', 'transfer_in', 'transfer_out'])->after('amount');
            $table->enum('status', ['pending', 'success', 'failed'])->default('success')->after('type');
            $table->unsignedBigInteger('recipient_id')->nullable()->after('status');
            $table->unsignedBigInteger('category_id')->nullable()->after('recipient_id');
            
            $table->foreign('recipient_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['recipient_id']);
            $table->dropColumn(['type', 'status', 'recipient_id', 'category_id']);
        });
    }
};
