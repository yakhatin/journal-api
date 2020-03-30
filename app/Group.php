<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $visible = ['id', 'name'];

    protected $fillable = ['name'];

    public function students () {
        return $this->hasMany(Student::class, 'group_id', 'id');
    }
}
