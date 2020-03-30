<?php

namespace App\Http\Controllers;

use App\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JournalController extends Controller
{
    private $model;

    public function __construct(Score $model)
    {
        $this->model = $model;
    }

    private function getSpecificData(Request $request) {
        $whereData = [];

        // Фильтр по группе
        if ($request->groupId) {
            array_push($whereData, ['students.group_id', '=', $request->groupId]);
        }

        // Фильтр по предмету
        if ($request->subjectId) {
            array_push($whereData, ['scores.subject_id', '=', $request->subjectId]);
        }

        // Получаем все даты
        $dates = DB::table('scores')
            ->select('scores.date', 'score_types.name AS score_type')
            ->join('score_types', 'scores.score_type', '=', 'score_types.id')
            ->groupBy('date', 'score_types.name')
            ->get();

        $columns = [];

        $dataSourceColumns = [
            array(
                'dataField' => 'name',
                'caption' => 'ФИО',
                'sortOrder' => 'asc'
            )
        ];

        // Динамичеиское формирование колонок с датой
        for ($i = 0; $i < count($dates); $i += 1) {
            $columnName = $dates[$i]->date;
            $dxColumnType = $dates[$i]->score_type;
            $defaultValue = $dates[$i]->score_type === 'boolean' ? 0 : 'NULL';
            array_push($columns, "MAX(CASE WHEN date LIKE '$columnName' THEN score ELSE $defaultValue END) AS '$columnName'");
            array_push(
                $dataSourceColumns,
                array(
                    'dataField' => $columnName,
                    'caption' => $columnName,
                    'dataType' => $dxColumnType
                )
            );
        }

        return (object) array(
            'where' => $whereData,
            'columns' => $columns,
            'dataSourceColumns' => $dataSourceColumns
        );
    }

    public function get(Request $request) {
        $requestData = $this->getSpecificData($request);

        $result = DB::table('scores')
            ->selectRaw('students.name, '.join(',', $requestData->columns))
            ->join('students', 'scores.student_id', '=', 'students.id')
            ->groupBy('scores.student_id', 'students.name')
            ->where($requestData->where)
            ->get();

        $this->sendResponse($result, 'Ok', 200);
    }

    public function sendColumns(Request $request) {
        $requestData = $this->getSpecificData($request);

        $this->sendResponse($requestData->dataSourceColumns, 'Ok', 200);
    }
}
