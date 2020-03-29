<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JournalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "score" => $this->score,
            "date" => $this->date,
            "student" => $this->student,
            "group" => $this->student->group,
            "subject" => $this->subject,
        ];
    }
}
