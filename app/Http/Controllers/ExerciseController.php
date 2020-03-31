<?php

namespace App\Http\Controllers;

use App\Exercise;
use App\Http\Requests\ExerciseRequest;
use Illuminate\Http\Request;

class ExerciseController extends ApiController
{
    public function __construct(Exercise $model, ExerciseRequest $controllerRequest)
    {
        $this->model = $model;
        $this->controllerRequest = $controllerRequest;
    }
}
