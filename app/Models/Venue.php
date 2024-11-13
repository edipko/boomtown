<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'city', 'state', 'zip', 'telephone'];

    // Define a relationship to events
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
