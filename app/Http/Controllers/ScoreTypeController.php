<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScoreTypeRequest;
use App\ScoreType;
use Illuminate\Http\Request;

class ScoreTypeController extends ApiController
{
    public function __construct(ScoreType $model, ScoreTypeRequest $controllerRequest)
    {
        $this->model = $model;
        $this->controllerRequest = $controllerRequest;
    }
}
