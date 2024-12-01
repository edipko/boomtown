<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MailingList extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'unsubscribe_token'];

    protected static function booted()
    {
        static::creating(function ($mailingList) {
            $mailingList->unsubscribe_token = Str::uuid()->toString();
        });
    }
}

?>

