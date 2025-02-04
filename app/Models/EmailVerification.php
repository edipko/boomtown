<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    use HasFactory;

    protected $table = 'email_verification';

    protected $fillable = [
        'email',
        'site_name',
        'verification_token',
        'is_verified',
        'form_data',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'form_data' => 'array',
    ];
}

?>

