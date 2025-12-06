<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->double('price',12,2);
            $table->smallInteger('rooms');
            $table->smallInteger('bathrooms');
            $table->integer('space');
            $table->smallInteger('floor');
            $table->string('title_deed');
            $table->string('governorate');
            $table->string('city');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
