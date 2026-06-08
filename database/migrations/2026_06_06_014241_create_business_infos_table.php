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
        Schema::create('business_infos', function (Blueprint $table) {
            $table->string('id')->primary()->default('main');
            $table->string('company_name')->default('GTA Tech');
            $table->string('address')->default('');
            $table->string('phone')->default('');
            $table->string('email')->default('');
            $table->string('working_hours')->default('');
            $table->text('about')->nullable();
            $table->string('facebook')->default('');
            $table->string('instagram')->default('');
            $table->string('whatsapp')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_infos');
    }
};
