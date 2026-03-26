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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // add, edit, delete, deactivate, sale, etc.
            $table->string('entity_type'); // user, product, category, sale, etc.
            $table->unsignedBigInteger('entity_id'); // id of the entity affected
            $table->unsignedBigInteger('performed_by')->nullable(); // user_id who performed action
            $table->text('description')->nullable(); // optional details
            $table->timestamps();

            // Optional foreign key for performed_by referencing users table
            $table->foreign('performed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
