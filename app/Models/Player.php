<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'date_of_birth',"status"];


    // public function teams()
    // {
    //     return $this->belongsToMany(Team::class)->withPivot('sort_order')->withTimestamps();
    // }

}
