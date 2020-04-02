<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $visible = ['id', 'name'];

    protected $fillable = ['name'];
}
