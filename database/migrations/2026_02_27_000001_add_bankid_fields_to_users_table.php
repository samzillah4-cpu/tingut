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
            $table->string('bankid_uuid')->nullable()->after('instagram_url');
            $table->string('bankid_status')->nullable()->after('bankid_uuid');
            $table->timestamp('bankid_verified_at')->nullable()->after('bankid_status');
            $table->string('national_id_number')->nullable()->after('bankid_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'bankid_uuid',
                'bankid_status',
                'bankid_verified_at',
                'national_id_number',
            ]);
        });
    }
};
