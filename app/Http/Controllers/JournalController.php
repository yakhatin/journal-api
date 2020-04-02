<?php

namespace App\Http\Controllers;

use App\Exercise;
use App\Group;
use App\Score;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JournalController extends Controller
{
    public function __construct(Score $model)
    {
        $this->model = $model;
    }

    private function getSpecificData(Request $request) {
        $selectColumns = ['scores.date', 'score_types.name AS score_type', 'score_types.id AS score_type_id'];
        $groupColumns = ['date', 'score_types.name', 'score_types.id'];
        $whereData = [];

        // Фильтр по группе
        if ($request->groupId) {
            array_push($whereData, ['students.group_id', '=', $request->groupId]);
        }

        // Фильтр по предмету
        if ($request->subjectId) {
            array_push($whereData, ['scores.subject_id', '=', $request->subjectId]);
        }

        // Фильтр по типу предмета
        if ($request->subjectTypeId) {
            array_push($whereData, ['scores.subject_type', '=', $request->subjectTypeId]);
        }

        // Фильтр по упражнению
        if ($request->isExercise) {
            array_push($whereData, ['scores.exercise_id', '<>', null]);
            array_push($selectColumns, 'exercises.name AS exercises_name');
            array_push($groupColumns, 'exercises.id', 'exercises.name');
        } else {
            array_push($whereData, ['scores.exercise_id', '=', null]);
        }

        // Получаем все даты
        $dates = DB::table('students')
            ->selectRaw(join(',', $selectColumns))
            ->join('scores', 'scores.student_id', '=', 'students.id')
            ->join('score_types', 'scores.score_type', '=', 'score_types.id')
            ->leftJoin('exercises', 'scores.exercise_id', '=', 'exercises.id')
            ->where($whereData)
            ->groupByRaw(join(',', $groupColumns))
            ->get();

        $columns = [];

        $dataSourceColumns = [
            array(
                'dataField' => 'name',
                'caption' => 'ФИО',
                'sortOrder' => 'asc',
                'allowEditing' => false
            )
        ];

        $dataSourceColumnsObject = (object) array();

        // Динамичеиское формирование колонок с датой
        for ($i = 0; $i < count($dates); $i += 1) {
            $sqlColumnName = $request->isExercise ? 'exercises.name' : 'date';
            $columnName = $request->isExercise ? $dates[$i]->exercises_name : $dates[$i]->date;
            $dxColumnType = $dates[$i]->score_type;
            $defaultValue = $dates[$i]->score_type === 'boolean' ? 0 : 'NULL';
            array_push($columns, "MAX(CASE WHEN $sqlColumnName LIKE '$columnName' THEN score ELSE $defaultValue END) AS '$columnName'");
            array_push(
                $dataSourceColumns,
                array(
                    'dataField' => $columnName,
                    'caption' => $columnName,
                    'dataType' => $dxColumnType
                )
            );
            $dataSourceColumnsObject->$columnName = (object) array(
                'score_type_id' => $dates[$i]->score_type_id
            );
        }

        return (object) array(
            'columns' => $columns,
            'dataSourceColumns' => $dataSourceColumns,
            'dataSourceColumnsObject' => $dataSourceColumnsObject
        );
    }

    public function get(Request $request) {
        $specificData = $this->getSpecificData($request);
        $subjectId = $request->subjectId;
        $groupId = $request->groupId;
        $subjectTypeId = $request->subjectTypeId;

        if($subjectId && $groupId && $subjectTypeId) {
            $isSubjectExists = Subject::find($subjectId);

            if (!$isSubjectExists) {
                return $this->sendError("Предмет с идентфикатором $subjectId не существует", '403', []);
            }

            $isGroupExists = Group::find($groupId);

            if (!$isGroupExists) {
                return $this->sendError("Группа с идентфикатором $groupId не существует", '403', []);
            }

            $columns = array_merge(['students.id', 'students.name'], $specificData->columns);
            $groupBy = ['students.id', 'students.name'];

            $result = DB::table('students')
                ->selectRaw(join(',', $columns))
                ->leftJoin('scores', function ($join) use ($subjectId, $subjectTypeId) {
                    $join
                        ->on('scores.student_id', '=', 'students.id')
                        ->where([
                            ['scores.subject_id', '=', $subjectId],
                            ['scores.subject_type', '=', $subjectTypeId]
                        ]);
                })
                ->leftJoin('exercises', 'scores.exercise_id', '=', 'exercises.id')
                ->groupByRaw(join(',', $groupBy))
                ->where('students.group_id', '=', $groupId)
                ->get();

            $this->sendResponse($result, 'Ok', 200);
        } else {
            $this->sendError('Переданы невалидные данные.', '403', []);
        }
    }

    public function sendColumns(Request $request) {
        $requestData = $this->getSpecificData($request);

        $this->sendResponse($requestData->dataSourceColumns, 'Ok', 200);
    }

    public function update(Request $request) {
        $dataSourceColumnsObject = $this->getSpecificData($request)->dataSourceColumnsObject;
        $keys = array_keys($request->values);

        if ($request->subjectTypeId && $request->id && $request->subjectId && count($keys) > 0) {
            $studentId = $request->id;
            $subjectId = $request->subjectId;
            $values = $request->values;
            $scoreType = $request->scoreType;
            $subjectTypeId = $request->subjectTypeId;
            $isExercise = $request->isExercise;
            $updateData = [];
            $exercises = array();

            if ($isExercise) {
                $exercises = Exercise::all()->toArray();
            }

            for ($i = 0; $i < count($keys); $i += 1) {
                $key = $keys[$i];
                $exerciseId = null;

                if ($isExercise) {
                    $exerciseIndex = array_search($key, array_column($exercises, 'name'));
                    $exerciseId = $exerciseIndex !== false ? $exercises[$exerciseIndex]['id'] : null;
                    if (!$exerciseId) {
                        $createdExercise = Exercise::create([
                            "name" => $key
                        ]);
                        $exerciseId = $createdExercise->id;
                    }
                }

                $r = $this->model
                     ->where([
                         $isExercise ? ['exercise_id', '=', $exerciseId] : ['date', '=', $key],
                         ['student_id', '=', $studentId],
                         ['subject_id', '=', $subjectId],
                         ['subject_type', '=', $subjectTypeId]
                     ])
                     ->first();

                 array_push(
                    $updateData,
                    (object) array(
                        'id' => $r ? $r->id : null,
                        'values' => array(
                            'student_id' => $studentId,
                            'subject_id' => $subjectId,
                            'subject_type' => $subjectTypeId,
                            'score' => $values[$key],
                            'date' => $isExercise ? null : $key,
                            'score_type' => isset($dataSourceColumnsObject->$key) ? $dataSourceColumnsObject->$key->score_type_id : ($scoreType || 1),
                            'exercise_id' => $exerciseId
                        )
                    ));
            }

            for ($i = 0; $i < count($updateData); $i += 1) {
                if ($updateData[$i]->id) {
                    $this->model
                        ->find($updateData[$i]->id)
                        ->fill($updateData[$i]->values)
                        ->push();
                } else {
                    $this->model
                        ->fill($updateData[$i]->values)
                        ->push();
                }
            }

            $this->sendResponse($updateData, 'Ok', 200);
        } else {
            $this->sendError('Переданы невалидные данные.', '403', []);
        }
    }
}
