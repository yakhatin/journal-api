<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScoreType extends Model
{
    protected $visible = ['id', 'name', 'description'];

    protected $fillable = ['name', 'description'];
}
