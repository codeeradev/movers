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
            $table->foreignId('blog_id')
                ->nullable()
                ->after('service_id')
                ->constrained('blogs')
                ->nullOnDelete();
        });

        DB::table('faqs')
            ->where('scope', 'blog')
            ->update(['scope' => 'blog']);
    }

    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('blog_id');
        });
    }
};
