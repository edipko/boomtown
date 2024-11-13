<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['venue_id', 'name', 'date', 'time', 'admission_cost'];

    // Define the inverse relationship to a venue
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
