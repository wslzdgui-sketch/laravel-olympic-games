<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sport_id')->constrained('sports')->onDelete('cascade');
            $table->foreignId('venue_id')->constrained('venues')->onDelete('restrict');
            $table->string('titre'); // ex: Qualifications, Demi-finale, Finale
            $table->date('jour');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->decimal('prix', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
