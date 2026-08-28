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
        Schema::table('contributors', function (Blueprint $table) {
            $table->string('sms_message_id')->nullable();
            $table->string('sms_delivery_status')->nullable();
            $table->timestamp('sms_delivery_updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contributors', function (Blueprint $table) {
            $table->dropColumn(['sms_message_id', 'sms_delivery_status', 'sms_delivery_updated_at']);
        });
    }
};
