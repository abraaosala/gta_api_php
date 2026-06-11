<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('estimator_issues', function (Blueprint $table) {
            $table->decimal('base_price', 10, 2)->nullable()->after('name');
            $table->string('estimated_time')->nullable()->after('base_price');
        });
    }

    public function down(): void
    {
        Schema::table('estimator_issues', function (Blueprint $table) {
            $table->dropColumn(['base_price', 'estimated_time']);
        });
    }
};
