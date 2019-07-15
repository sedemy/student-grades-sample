<?php

namespace App\Imports;

use App\Grade;
use App\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

use DB;

class GradesImport implements ToModel,WithStartRow
{
    protected $course;
    public function __construct($course){
        $this->course = $course;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        $check = Student::where('name',($row[0]))->first(); //DB::raw("TRIM(name)")
        
        //dd((empty($check) == true));

        if(!$check){
           
            $student = new Student();
            $student->name = ($row[0]);
            $student->code = '';
            $student->save();

            $student_id = $student->id;
        }
        else{
            
             $student_id = $check->id;
         
         }

        if((intval($row[1]) > 0) || (intval($row[2]) > 0) || (intval($row[3]) > 0) ){

            $grade = Grade::where('student_id',$student_id)->where('course_id',$this->course->id)->first();

            if(empty($grade) == true){
                $grade = new Grade();
            }

            $grade->student_id = $student_id;
            $grade->course_id = $this->course->id;
            $grade->total_oral = intval($row[1]);
            $grade->total_work = intval($row[2]);
            $grade->total_exam = intval($row[3]);
            
            $grade->save();

        }
        
        
        // return new Grade([
        //     'student_id'=> $student_id,
        //     'course_id' => $this->course->id,
        //     'total_oral' => intval($row[1]),
        //     'total_work' => intval($row[2]), 
        //     'total_exam' => intval($row[3]), 
        // ]);

    }
    public function startRow(): int
    {
        return 2;
    }
}
