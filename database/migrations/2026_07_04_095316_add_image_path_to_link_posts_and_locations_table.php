<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('link_posts', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('id');
            $table->text('image_url')->nullable()->change();
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('link_posts', function (Blueprint $table) {
            $table->dropColumn('image_path');
            $table->text('image_url')->nullable(false)->change();
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }
};
