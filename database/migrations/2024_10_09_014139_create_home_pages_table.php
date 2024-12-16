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
        Schema::create('home_pages', function (Blueprint $table) {
            $table->id();
            $table->string('pretitle')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('video')->nullable();
            $table->text('image')->nullable();
            $table->string('point_one')->nullable();
            $table->string('point_two')->nullable();
            $table->string('point_three')->nullable();

            $table->string('service_one')->nullable();
            $table->string('service_two')->nullable();
            $table->string('service_three')->nullable();
            $table->string('service_four')->nullable();

            $table->string('aboutpretitle')->nullable();
            $table->string('abouttitle')->nullable();
            $table->string('aboutsubtitle')->nullable();
            $table->text('aboutimageone')->nullable();
            $table->text('aboutimagetwo')->nullable();
            $table->string('aboutpoint_one')->nullable();
            $table->string('aboutpoint_two')->nullable();
            $table->string('aboutpoint_three')->nullable();

            $table->string('abouttwopretitle')->nullable();
            $table->string('abouttwotitle')->nullable();
            $table->string('abouttwosubtitle')->nullable();
            $table->text('abouttwoimageone')->nullable();
            $table->string('abouttwopoint_one')->nullable();
            $table->string('abouttwopoint_two')->nullable();
            $table->string('abouttwopoint_three')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_pages');
    }
};
