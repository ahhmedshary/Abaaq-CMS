<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('page')->default('home');        // للتوسع مستقبلًا
            $table->string('type');                          // hero, categories, featured ...
            $table->string('label');                         // اسم ظاهر في الـ admin
            $table->boolean('is_visible')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->json('settings')->nullable();            // كل إعدادات الـ section
            $table->timestamps();

            $table->unique(['page', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_sections');
    }
};
