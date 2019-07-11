@extends('layouts.master')

@section('content')




<section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Grades</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row margin-bottom">
                <div class="col-sm-4">
                  <div class="form-group">
                        <label>Course</label>
                        <select class="form-control col-xs-4" onChange="window.location='{{ url('grades') }}/'+this.value;" >
                          <option value="">--Choose Course--</option>
                          @for($i = 0 ; $i < count($allcourses) ; $i++)
                            <option value="{{ $allcourses[$i]->id }}"
                              @if($selectedCourse==$allcourses[$i]->id) selected="selected" @endif>{{ $allcourses[$i]->name }}</option>
                          @endfor
                        </select>
                  </div>
                </div>
                

              </div>

              <div class="form-group has-feedback" >
                  @include('grades.studentsTable')
              </div>


            </div>
            <!-- /.box-body -->
                
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>












@endsection