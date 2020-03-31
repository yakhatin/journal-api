<?php

namespace App\Http\Controllers;

use App\Subject;

class SubjectController extends ApiController
{
    public function __construct(Subject $model)
    {
        $this->model = $model;
    }
}
