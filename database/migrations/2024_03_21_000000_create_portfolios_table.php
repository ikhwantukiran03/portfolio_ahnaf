<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_type')->nullable();
            $table->string('client')->nullable();
            $table->enum('tag', [
                'Document Translation',
                'Localization',
                'Transcription and Translation',
                'Subtitling and Captioning',
                'Interpretation',
                'Proofreading and Editing of Translations'
            ]);
            $table->timestamps();
        });

        // Add MEDIUMBLOB column using raw SQL
        DB::statement("ALTER TABLE portfolios ADD portfolio_file MEDIUMBLOB");
    }

    public function down()
    {
        Schema::dropIfExists('portfolios');
    }
}; 