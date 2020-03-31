<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectType extends Model
{
    protected $visible = ['id', 'name'];

    protected $fillable = ['name'];
}
