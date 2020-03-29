<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $visible = ['id', 'name'];

    protected $fillable = ['name'];

    public function scores() {
        return $this->hasMany(Score::class, 'student_id', 'id');
    }

    public function group() {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
}
