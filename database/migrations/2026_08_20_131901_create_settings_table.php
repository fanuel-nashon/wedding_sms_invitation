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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('sms_token');
            $table->string('sms_username');
            $table->string('sms_password');
            $table->string('sms_sender_id');
            $table->timestamps();
        });
    }

    /*
        'sms_token',
        'sms_username',
        'sms_password',
        'sms_sender_id'
    */


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
