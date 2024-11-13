<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteData extends Model
{
    protected $fillable = [
        'section',
        'content',
    ];
}
