<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'state', 'country'];

    public function players()
    {
        return $this->belongsToMany(Player::class, 'team_players')->withPivot('sort_order')->orderBy('sort_order');
    }

    // public function players()
    // {
    //     return $this->belongsToMany(Player::class)->withPivot('sort_order')->withTimestamps();
    // }

}
