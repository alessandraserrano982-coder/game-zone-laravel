<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->date('release_date')->nullable();
            $table->string('developer')->nullable();
            $table->string('publisher')->nullable();
            $table->text('minimum_requirements')->nullable();
            $table->text('recommended_requirements')->nullable();
            $table->string('trailer_url')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn([
                'release_date',
                'developer',
                'publisher',
                'minimum_requirements',
                'recommended_requirements',
                'trailer_url',
            ]);
        });
    }
};