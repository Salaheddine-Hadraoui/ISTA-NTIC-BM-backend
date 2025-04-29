<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiers extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];
    public function schedule(){
        return $this->hasOne(Schedule::class);
    }
}
