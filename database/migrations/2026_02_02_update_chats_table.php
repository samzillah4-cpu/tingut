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
        Schema::table('chats', function (Blueprint $table) {
            // Add user_id for when chat is initiated by a registered user
            $table->unsignedBigInteger('user_id')->nullable()->after('id');

            // Add chat_type: 'customer_support', 'seller_customer', 'seller_admin'
            $table->string('chat_type')->default('customer_support')->after('user_id');

            // Add related_user_id for seller-customer or seller-admin chats
            $table->unsignedBigInteger('related_user_id')->nullable()->after('chat_type');

            // Add subject/context for the chat
            $table->string('subject')->nullable()->after('related_user_id');

            // Add foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('related_user_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::table('chat_messages', function (Blueprint $table) {
            // Add user_id for sender identification
            $table->unsignedBigInteger('user_id')->nullable()->after('chat_id');

            // Add read_at timestamp
            $table->timestamp('read_at')->nullable()->after('message');

            // Add foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'read_at']);
        });

        Schema::table('chats', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['related_user_id']);
            $table->dropColumn(['user_id', 'chat_type', 'related_user_id', 'subject']);
        });
    }
};
