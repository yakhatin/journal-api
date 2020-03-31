<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Student;
use Illuminate\Http\Request;

class StudentController extends ApiController
{
    public function __construct(Student $model, StudentRequest $request)
    {
        $this->model = $model;
        $this->controllerRequest = $request;
    }

    public function get(Request $request) {
        $whereData = [];

        if ($request->group_id) {
            array_push($whereData, ['group_id', '=', $request->group_id]);
        }

        $result = $this->model
            ->where($whereData)
            ->get();

        $this->sendResponse($result, 'Ok', 200);
    }
}
