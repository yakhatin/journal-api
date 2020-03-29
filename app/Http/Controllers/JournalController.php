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

    public function get(Request $request) {
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
        $dates = DB::table('scores')->select('date')->groupBy('date')->get();

        $columns = [];

        // Динамичеиское формирование колонок с датой
        for ($i = 0; $i < count($dates); $i += 1) {
            $columnName = $dates[$i]->date;
            array_push($columns, "MAX(CASE WHEN date LIKE '$columnName' THEN score END) AS '$columnName'");
        }

        $result = DB::table('scores')
            ->selectRaw('students.name, '.join(',', $columns))
            ->join('students', 'scores.student_id', '=', 'students.id')
            ->groupBy('scores.student_id', 'students.name')
            ->where($whereData)
            ->get();

        $this->sendResponse($result, 'Ok', 200);
    }
}
