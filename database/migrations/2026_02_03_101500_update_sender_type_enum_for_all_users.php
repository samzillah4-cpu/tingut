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
        // Update the enum to include all user types
        // First drop the enum, then add a new one with more values
        // Using raw SQL for MySQL enum modification
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE chat_messages MODIFY COLUMN sender_type ENUM('visitor', 'admin', 'seller', 'customer') NOT NULL DEFAULT 'visitor'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE chat_messages MODIFY COLUMN sender_type ENUM('visitor', 'admin') NOT NULL DEFAULT 'visitor'");
    }
};
