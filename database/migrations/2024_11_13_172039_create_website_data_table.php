<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsiteDataTable extends Migration
{
    public function up()
    {
        Schema::create('website_data', function (Blueprint $table) {
            $table->id();
            $table->string('section')->unique(); // e.g., 'about', 'hero', etc.
            $table->text('content'); // Store the actual content
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('website_data');
    }
}
