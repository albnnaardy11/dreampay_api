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
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->after('email');
            $table->string('pin')->nullable()->after('password');
            $table->decimal('balance', 15, 2)->default(0)->after('pin');
            $table->integer('points')->default(0)->after('balance');
            $table->string('tier')->default('Bronze')->after('points');
            $table->string('qr_code')->nullable()->after('tier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['password', 'pin', 'balance', 'points', 'tier', 'qr_code']);
        });
    }
};
