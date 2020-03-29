<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $visible = ['id', 'score', 'date'];

    protected $fillable = ['score', 'date'];

    public function student() {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function subject() {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
