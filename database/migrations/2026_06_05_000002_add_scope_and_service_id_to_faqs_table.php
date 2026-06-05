<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->string('scope')->default('home')->after('answer');
            $table->foreignId('service_id')
                ->nullable()
                ->after('scope')
                ->constrained()
                ->nullOnDelete();
        });

        DB::table('faqs')->update([
            'scope' => 'home',
            'service_id' => null,
        ]);
    }

    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('service_id');
            $table->dropColumn('scope');
        });
    }
};
