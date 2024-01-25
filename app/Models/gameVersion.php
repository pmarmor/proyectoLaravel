<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gameVersion extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'idGame',
        'version',
        'content',
    ];
}
