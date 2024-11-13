<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGigLeadsTable extends Migration
{
    public function up()
    {
        Schema::create('gig_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('telephone');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gig_leads');
    }
}
