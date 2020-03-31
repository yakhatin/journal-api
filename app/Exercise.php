<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $visible = ['id', 'name', 'group_id', 'subject_type', 'subject_id'];

    protected $fillable = ['name', 'group_id', 'subject_type', 'subject_id'];
}
