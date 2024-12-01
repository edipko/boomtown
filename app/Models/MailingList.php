<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MailingList extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'unsubscribe_token']; // Include 'name'

    protected static function booted()
    {
        static::creating(function ($mailingList) {
            $mailingList->unsubscribe_token = Str::uuid()->toString();
        });
    }
}


?>

