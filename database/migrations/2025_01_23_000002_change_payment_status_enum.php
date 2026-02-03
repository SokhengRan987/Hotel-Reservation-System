<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // PostgreSQL: Change enum type
            DB::statement("ALTER TYPE payments_status_check RENAME TO payments_status_check_old");
            DB::statement("CREATE TYPE payments_status_check AS ENUM ('pending', 'completed', 'failed', 'refunded')");
            DB::statement("ALTER TABLE payments ALTER COLUMN status TYPE payments_status_check USING status::text::payments_status_check");
            DB::statement("DROP TYPE payments_status_check_old");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Revert to old enum
            DB::statement("ALTER TYPE payments_status_check RENAME TO payments_status_check_new");
            DB::statement("CREATE TYPE payments_status_check AS ENUM ('pending', 'paid', 'failed', 'refunded')");
            DB::statement("ALTER TABLE payments ALTER COLUMN status TYPE payments_status_check USING status::text::payments_status_check");
            DB::statement("DROP TYPE payments_status_check_new");
        });
    }
};
