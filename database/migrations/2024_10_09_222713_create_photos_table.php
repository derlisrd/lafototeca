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
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('event_id')->unsigned()->nullable();
            $table->string('titulo')->nullable();
            $table->text('url_b');
            $table->text('url_q')->nullable();
            $table->text('url_m')->nullable();
            $table->text('host')->nullable();
            $table->text('name')->nullable();
            $table->string('extension')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
