<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->boolean('is_reported')->default(false)->after('comment');
            $table->unsignedSmallInteger('report_count')->default(0)->after('is_reported');
            $table->timestamp('reported_at')->nullable()->after('report_count');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['is_reported', 'report_count', 'reported_at']);
        });
    }
};
