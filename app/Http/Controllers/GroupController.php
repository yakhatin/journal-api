<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\GroupRequest;

class GroupController extends ApiController
{
    public function __construct(Group $model, GroupRequest $request)
    {
        $this->model = $model;
        $this->controllerRequest = $request;
    }
}
