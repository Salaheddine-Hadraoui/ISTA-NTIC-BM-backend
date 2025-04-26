<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Module;

class Course extends Model
{
    protected $fillable =['name','course_pdf','module_id'];
    public function module(){
        return $this->belongsTo(related: Module::class);
    }
}
