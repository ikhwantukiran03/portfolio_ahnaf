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
        Schema::create('social_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // email, phone, linkedin, github, twitter, facebook, instagram, website, behance, dribbble, other
            $table->string('label'); // Display name like "Work Email", "Personal Phone"
            $table->string('value'); // The actual contact value (URL, email, phone number)
            $table->string('icon')->nullable(); // FontAwesome icon class
            $table->string('custom_type')->nullable(); // For 'other' type - stores the custom type name
            $table->text('description')->nullable(); // Optional description
            $table->boolean('is_public')->default(true); // Show on public profile
            $table->integer('sort_order')->default(0); // For custom ordering
            $table->string('status')->default('active'); // active, inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_contacts');
    }
};