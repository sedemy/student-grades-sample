<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\GradeService;

use App\Exports\GradesExport;
use App\Imports\GradesImport;
use Maatwebsite\Excel\Facades\Excel;

class GradesController extends Controller
{
    public function grades($selectedCourse = 0)
    {
        if($selectedCourse != 0){
            $students = GradeService::getStudents();
            $course = GradeService::getCourseDetails($selectedCourse);
            $grades = GradeService::getGrades($selectedCourse, $students->pluck('id'));
        }
        
        $allcourses = GradeService::getAllCourses();
        
        return view('grades.index')->with(compact('selectedCourse', 'students', 'course','grades','allcourses'));
    }

    public function updateGrade(Request $request, $course){

        GradeService::updateGrade($request,$course);

    }


    public function export($selectedCourse = 0) 
    {
        if($selectedCourse > 0){
            $course = GradeService::getCourseDetails($selectedCourse);
            return Excel::download(new GradesExport($course), 'grades-'.$course->name.'.xlsx');
        }
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request, $selectedCourse = 0) 
    {
        if($selectedCourse > 0 && $request->has('file')){
            $course = GradeService::getCourseDetails($selectedCourse);
            Excel::import(new GradesImport($course),request()->file('file'));
        }
        return back();
    }

}
