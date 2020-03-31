<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class ApiController extends Controller
{
    protected $model;
    protected $controllerRequest;

    public function get(Request $request) {
        $result = $this->model->get();

        $this->sendResponse($result, 'Ok', 200);
    }

    public function delete(Request $request) {
        if ($request->id) {
            $this->model->find($request->id)->delete();

            $this->sendResponse([], 'Запись успешно удалена.', 204);
        } else {
            $this->sendError('Переданы невалидные данные.', '403', []);
        }
    }

    public function update(Request $request) {
        if ($request->id) {
            $entity = $this->model->find($request->id);

            if (!$entity) {
                $this->sendError('Запись не неайдена.', 404);
            } else {
                $data = $request->validate($this->controllerRequest->rules, $this->controllerRequest->messages());

                $entity->fill($data)->save();

                $this->sendResponse($data, 'Запись успешно обновлена.', 200);
            }

        } else {
            $this->sendError('Переданы невалидные данные.', '403', []);
        }
    }

    public function insert(Request $request) {
        $data = $request->validate($this->controllerRequest->rules, $this->controllerRequest->messages());

        if ($data) {
            $this->model->fill($data)->push();
            return $this->sendResponse($data, 'Запись успешно создана.', 201);
        } else {
            $this->sendError('Переданы невалидные данные.', '403', []);
        }
    }
}
