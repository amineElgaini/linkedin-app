<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // candidat
            $table->foreignId('job_offer_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'reviewed', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
            
            // Un candidat ne peut postuler qu'une seule fois à une offre
            $table->unique(['user_id', 'job_offer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};