<?php

namespace App\Services;

use App\Student;
use App\Course;
use App\Grade;

class GradeService 
{
    public static function getStudents(){
        return Student::paginate(10);
    }

    public static function getAllCourses(){
        return Course::get();
    }
    public static function getCourseDetails($course=0){
        return Course::find($course);
    }
    public static function getGrades($course, $students_ids){
        
        return Grade::where('course_id',$course)
        ->whereIn('student_id',$students_ids)
        ->get();
    }

    public static function updateGrade($request,$course){
        
        $student_id = $request->input('student_id');
        $student_name = $request->input('name_'.$student_id);
        $arr['student_id'] = $student_id;

        $arr['course_id'] = $request->input('course_id');
        
        $arr['total_oral'] = $request->input('oral_'.$student_id);
        $arr['total_work'] = $request->input('work_'.$student_id);
        $arr['total_exam'] = $request->input('exam_'.$student_id);
        
        $check = Grade::where('student_id',$student_id)->where('course_id',$arr['course_id'])->first();

        (!empty($check)) ? $check->update($arr) : Grade::create($arr);


        // update student name
        Student::where('id',$student_id)->update(['name'=>$student_name]);
        
        
    }


    public static function export($course){
        

        $students = Student::get(['id','name']);
        
        $grades = Grade::where('course_id',$course->id)->get();


        for($i = 0 ; $i < count($students) ; $i++){
            
            for($k=0 ; $k < count($grades) ; $k++){

                if($students[$i]->id == $grades[$k]->student_id){


                    $students[$i]->total_oral = $grades[$k]->total_oral;
                    $students[$i]->total_work = $grades[$k]->total_work;
                    $students[$i]->total_exam = $grades[$k]->total_exam;

                    $students[$i]->total = 
                    ($grades[$k]->total_oral ?? 0) + ($grades[$k]->total_work ?? 0) + ($grades[$k]->total_exam ?? 0);

                    $students[$i]->percentage = 
                    ($students[$i]->total > 0)
                    ?
                    round((($students[$i]->total / ($course->oral + $course->work + $course->exam)) * 100) , 2) . "%"
                    :'';        

                    //unset($students[$i]->id);
                    
                    break;
                }

            }

            unset($students[$i]['id']);
        }
        
        
        return $students;

    }
}
