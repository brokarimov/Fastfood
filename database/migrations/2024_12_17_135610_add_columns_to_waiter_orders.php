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
        Schema::table('waiter_orders', function (Blueprint $table) {
            $table->string('status_waiter')->default(0);
            $table->string('status_manager')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('waiter_orders', function (Blueprint $table) {
            $table->dropColumn('status_waiter');
            $table->dropColumn('status_manager');
        });
    }
};
