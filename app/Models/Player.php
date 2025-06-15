<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;


    protected $guarded = [];


    // protected $fillable = ['name', 'email', 'date_of_birth',"status"];


    public function teamPlayer()
    {
        return $this->belongsToMany(Team::class, 'team_players')->withPivot('sort_order')->orderBy('sort_order');
    }

}
