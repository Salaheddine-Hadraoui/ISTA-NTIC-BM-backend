<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Course extends Model
{
    use HasApiTokens;
    protected $fillable=[
        'title',
        'description',
        'file_path'
    ];
}
