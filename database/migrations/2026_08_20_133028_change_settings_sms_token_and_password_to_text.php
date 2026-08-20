<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE settings ALTER COLUMN sms_token TYPE TEXT');
        DB::statement('ALTER TABLE settings ALTER COLUMN sms_password TYPE TEXT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE settings ALTER COLUMN sms_token TYPE VARCHAR(255)');
        DB::statement('ALTER TABLE settings ALTER COLUMN sms_password TYPE VARCHAR(255)');
    }
};
