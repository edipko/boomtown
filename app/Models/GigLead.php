<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GigLead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'telephone', 'notes', 'followed_up'
    ];
}
