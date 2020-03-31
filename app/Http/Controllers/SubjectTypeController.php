<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectTypeRequest;
use App\SubjectType;
use Illuminate\Http\Request;

class SubjectTypeController extends ApiController
{
    public function __construct(SubjectType $model, SubjectTypeRequest $controllerRequest)
    {
        $this->model = $model;
        $this->controllerRequest = $controllerRequest;
    }
}
