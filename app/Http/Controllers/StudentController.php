<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public $model = null;

    public function __construct(Student $model)
    {
        $this->model = $model;
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

    public function delete(Request $request) {
        if ($request->id) {
            $this->model->find($request->id)->delete();

            $this->sendResponse([], 'Запись успешно удалена', 204);
        } else {
            $this->sendError('Переданы невалидные данные.', '403', []);
        }
    }

    public function update(StudentRequest $request) {
        if ($request->id) {
            $entity = $this->model->find($request->id);

            if (!$entity) {
                $this->sendError('Not Found', 404);
            } else {
                $data = $request->validated();

                $entity->fill($data)->save();

                $this->sendResponse($data, 'Запись успешно обновлена', 200);
            }

        } else {
            $this->sendError('Переданы невалидные данные.', '403', []);
        }
    }

    public function insert(StudentRequest $request) {
        $data = $request->validated();

        if ($data) {
            $this->model->fill($data)->push();
            return $this->sendResponse($data, 'Запись успешно создана.', 201);
        } else {
            $this->sendError('Переданы невалидные данные.', '403', []);
        }
    }
}
