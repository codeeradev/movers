<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('settings')) {
            return;
        }

        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'hero_title')) {
                $table->string('hero_title')->nullable()->after('favicon');
            }

            if (!Schema::hasColumn('settings', 'hero_subtitle')) {
                $table->string('hero_subtitle')->nullable()->after('hero_title');
            }

            if (!Schema::hasColumn('settings', 'hero_description')) {
                $table->longText('hero_description')->nullable()->after('hero_subtitle');
            }

            if (!Schema::hasColumn('settings', 'hero_button_text')) {
                $table->string('hero_button_text')->nullable()->after('hero_description');
            }

            if (!Schema::hasColumn('settings', 'hero_button_url')) {
                $table->string('hero_button_url')->nullable()->after('hero_button_text');
            }

            if (!Schema::hasColumn('settings', 'hero_form_title')) {
                $table->string('hero_form_title')->nullable()->after('hero_button_url');
            }

            if (!Schema::hasColumn('settings', 'hero_background_image')) {
                $table->string('hero_background_image')->nullable()->after('hero_form_title');
            }

            if (!Schema::hasColumn('settings', 'home_services_title')) {
                $table->string('home_services_title')->nullable()->after('hero_background_image');
            }

            if (!Schema::hasColumn('settings', 'home_services_subtitle')) {
                $table->string('home_services_subtitle')->nullable()->after('home_services_title');
            }

            if (!Schema::hasColumn('settings', 'home_services_items')) {
                $table->longText('home_services_items')->nullable()->after('home_services_subtitle');
            }

            if (!Schema::hasColumn('settings', 'home_choose_title')) {
                $table->string('home_choose_title')->nullable()->after('home_services_items');
            }

            if (!Schema::hasColumn('settings', 'home_choose_subtitle')) {
                $table->string('home_choose_subtitle')->nullable()->after('home_choose_title');
            }

            if (!Schema::hasColumn('settings', 'home_choose_items')) {
                $table->longText('home_choose_items')->nullable()->after('home_choose_subtitle');
            }

            if (!Schema::hasColumn('settings', 'home_stats_title')) {
                $table->string('home_stats_title')->nullable()->after('home_choose_items');
            }

            if (!Schema::hasColumn('settings', 'home_stats_subtitle')) {
                $table->string('home_stats_subtitle')->nullable()->after('home_stats_title');
            }

            if (!Schema::hasColumn('settings', 'home_stats_items')) {
                $table->longText('home_stats_items')->nullable()->after('home_stats_subtitle');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('settings')) {
            return;
        }

        Schema::table('settings', function (Blueprint $table) {
            $columns = [
                'hero_title',
                'hero_subtitle',
                'hero_description',
                'hero_button_text',
                'hero_button_url',
                'hero_form_title',
                'hero_background_image',
                'home_services_title',
                'home_services_subtitle',
                'home_services_items',
                'home_choose_title',
                'home_choose_subtitle',
                'home_choose_items',
                'home_stats_title',
                'home_stats_subtitle',
                'home_stats_items',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
