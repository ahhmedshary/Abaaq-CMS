<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->string('tagline');
            $table->string('location')->nullable();
            $table->string('email');
            $table->string('avatar')->nullable();
            $table->string('resume_url')->nullable();
            $table->json('social')->nullable(); // [{label, url}]
            $table->json('stats')->nullable();  // [{value, label}]
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
