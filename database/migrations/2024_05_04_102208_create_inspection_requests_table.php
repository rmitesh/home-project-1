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
        Schema::create('inspection_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('property_id')->unsigned();
            $table->integer('inspector_id')->unsigned();
            $table->integer('requested_by')->unsigned();
            $table->string('request_number', 20)->unique();
            $table->timestamp('book_at')->nullable();
            $table->string('notes', 151)->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'rescheduled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_requests');
    }
};
