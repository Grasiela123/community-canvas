<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'picture', 'date_made',
    ];

    public function poll() {
        return $this->belongsTo(Poll::class);
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }
}
