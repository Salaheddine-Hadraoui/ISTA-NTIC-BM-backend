<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable=['schedule_pdf','filiers_id'];
    public function filiers(){
        return $this->belongsTo(Filiers::class);
    }
}
