<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\GroupRequest;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public $model = null;

    public function __construct(Group $model)
    {
        $this->model = $model;
    }

    public function get(Request $request) {
        $result = $this->model->get();

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

    public function update(GroupRequest $request) {
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
}
