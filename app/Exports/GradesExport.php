<?php

namespace App\Exports;

use App\Grade;
use App\Student;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Services\GradeService;

class GradesExport implements FromCollection, WithHeadings,ShouldAutoSize
{
    protected $course;

    public function __construct($course){
        $this->course = $course;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return GradeService::export($this->course);
        // return Grade::all();
    }
    public function headings(): array
    {
        return [
            'Name',
            'Oral ('.$this->course->oral.")",
            'Work ('.$this->course->work.")",
            'Exam ('.$this->course->exam.")",
            'Total ('.($this->course->oral + $this->course->work + $this->course->exam).")",
            'Percentage (100%)'
        ];
    }
}
