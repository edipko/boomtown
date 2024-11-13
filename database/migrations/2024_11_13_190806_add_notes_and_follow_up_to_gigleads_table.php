<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('gig_leads', function (Blueprint $table) {
            $table->text('notes')->nullable();
            $table->boolean('followed_up')->default(false);
        });
    }

    public function down()
    {
        Schema::table('gig_leads', function (Blueprint $table) {
            $table->dropColumn(['notes', 'followed_up']);
        });
    }
};
