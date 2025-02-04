<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('email_verification', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('site_name');
            $table->string('verification_token');
            $table->boolean('is_verified')->default(false);
            $table->json('form_data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_verification');
    }
};
?>


