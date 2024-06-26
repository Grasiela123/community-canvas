<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description', 'picture', 'date_made'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function options() {
        return $this->hasMany(Option::class);
    }

    public function votes() {
        return $this->hasManyThrough(Vote::class, Option::class);
    }

    public function userVote() {
        return $this->votes()->where('user_id', auth()->id())->first();
    }

    public function hasUserVoted() {
        return $this->votes()->where('user_id', auth()->id())->exists();
    
    }
}
