<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TotalClass extends Model
{
    protected $table = 'total_class';

    public $timestamps = false;

    protected $fillable = [
        'classId',
        'titleId',
        'title',
        'videoLink',
    ];
}
