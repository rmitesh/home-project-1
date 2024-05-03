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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->integer('buyer_id')->unsigned();
            $table->string('address', 151);
            $table->timestamp('built_in')->nullable();
            $table->integer('units')->unsigned()->default(0);
            $table->integer('bedrooms')->unsigned()->default(0);
            $table->integer('bathrooms')->unsigned()->default(0);
            $table->integer('garages')->unsigned()->default(0);
            $table->string('square_foot', 10)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
