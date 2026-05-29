<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('car_move_requests')) {
            return;
        }

        Schema::table('car_move_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('car_move_requests', 'pickup_state_id') && Schema::hasTable('states')) {
                $table->foreignId('pickup_state_id')->nullable()->constrained('states')->nullOnDelete();
            }

            if (!Schema::hasColumn('car_move_requests', 'drop_state_id') && Schema::hasTable('states')) {
                $table->foreignId('drop_state_id')->nullable()->constrained('states')->nullOnDelete();
            }

            if (!Schema::hasColumn('car_move_requests', 'car_type_id') && Schema::hasTable('car_types')) {
                $table->foreignId('car_type_id')->nullable()->constrained('car_types')->nullOnDelete();
            }

            if (!Schema::hasColumn('car_move_requests', 'price_range')) {
                $table->string('price_range')->nullable();
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('car_move_requests')) {
            return;
        }

        Schema::table('car_move_requests', function (Blueprint $table) {
            if (Schema::hasColumn('car_move_requests', 'pickup_state_id')) {
                $table->dropConstrainedForeignId('pickup_state_id');
            }

            if (Schema::hasColumn('car_move_requests', 'drop_state_id')) {
                $table->dropConstrainedForeignId('drop_state_id');
            }

            if (Schema::hasColumn('car_move_requests', 'car_type_id')) {
                $table->dropConstrainedForeignId('car_type_id');
            }

            if (Schema::hasColumn('car_move_requests', 'price_range')) {
                $table->dropColumn('price_range');
            }
        });
    }
};
