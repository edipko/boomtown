<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class AddFacebookLinkToWebsiteDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('website_data')->insert([
            'section' => 'facebook_link',
            'content' => 'https://www.facebook.com/profile.php?id=61558485951813',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('website_data')->where('section', 'facebook_link')->delete();
    }
}
