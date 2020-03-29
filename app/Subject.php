<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $visible = ['id', 'title'];

    protected $fillable = ['title'];

    protected function scores() {
        return $this->hasMany(Score::class, 'subject_id', 'id');
    }
}
