@if(!empty($students) && !empty($course))

<div class="form-group">
    <div class="col-sm-3 margin-bottom">
      <a href="{{ url('export/'.$course->id) }}" class="form-control btn btn-primary">Export Excel file</a>
    </div>
    <div class="col-sm-6 margin-bottom">

        <form action="{{ url('import/'.$course->id) }}" method="POST" name="importform" 
        enctype="multipart/form-data">
          @csrf
          <div class="col-sm-6">
              <input type="file" name="file" class="form-control">
          </div>
          
          <div class="col-sm-6">
              <button class="btn btn-success">Import File</button>
          </div>
      </form>

    </div>
    
</div>

    


    <form id="frm" name="frm" action="{{url('update-grade/'.$course->id)}}" onsubmit="return false;">
      @csrf
      <input type="hidden" name="course_id" id="course_id" value="{{$course->id}}" >

        <table id="gradesTable" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th>Student Name.</th>
              <th>Oral ( {{ $course->oral }} )</th>
              <th>Work ( {{ $course->work }} )</th>
              <th>Exam ( {{ $course->exam }} )</th>
              <th>Total ( {{ ($course->oral + $course->work + $course->exam) }} )</th>
              <th>Percentage ( 100% )<th>
            </tr>
            </thead>
            <tbody>
            @for($i=0; $i < count($students); $i++)
                @php
                    $total_oral = 0; $total_work=0; $total_exam = 0; 
                    for($k=0; $k < count($grades) ; $k++){
                      if($students[$i]->id == $grades[$k]->student_id && $course->id == $grades[$k]->course_id ){
                          $total_oral = $grades[$k]->total_oral;
                          $total_work = $grades[$k]->total_work;
                          $total_exam = $grades[$k]->total_exam;
                        break;
                      }
                    }
                    $total = $total_oral + $total_work + $total_exam;
                @endphp    
   
   
            <tr>
              <td>
                <input type="text" id="name_{{$students[$i]->id}}" name="name_{{$students[$i]->id}}" 
                value="{{ $students[$i]->name }}">
                </td>
              <td>
              <input type="text" id="oral_{{$students[$i]->id}}" name="oral_{{$students[$i]->id}}" 
                value="@if($total_oral !=0 ){{ $total_oral }}@endif"
                @if(!($course->oral > 0)) style="background-color:#eee;" @endif>
              </td>
              <td>
                <input type="text" id="work_{{$students[$i]->id}}" name="work_{{$students[$i]->id}}"
                value="@if($total_work !=0 ){{ $total_work }}@endif" 
                @if(!($course->work > 0)) style="background-color:#eee;" @endif>
              </td>
              <td>
                <input type="text" id="exam_{{$students[$i]->id}}" name="exam_{{$students[$i]->id}}"
                value="@if($total_exam !=0 ){{ $total_exam }}@endif" 
                @if(!($course->exam > 0)) style="background-color:#eee;" @endif>
              </td>
              <td id="total_{{$students[$i]->id}}">
                  @if( $total> 0)
                    {{ $total }}
                  @endif
              </td>
              <td  id="percentage_{{$students[$i]->id}}">
                  @if( $total> 0)
                    {{ round((($total/($course->oral + $course->work + $course->exam)) * 100) , 2)  }}%
                  @endif
              </td>
            </tr>
            @endfor
            </tbody>
            
          </table>
      </form>
      <div class="box-footer clearfix">{!! $students->render() !!}</div>

  @else

  <div class="pad margin no-print">
      <div class="callout callout-info" style="margin-bottom: 0!important;">
        <h4> Please choose Course.</h4>
        
      </div>
    </div>
    
  @endif


@if(!empty($course))
  @push('js')
      <script>
          $("input[type='text']").on('change',function(e){

            let student_id = $(this).attr('id').split('_')[1];
            let oral = $('#oral_'+student_id).val();
            if(!(oral > 0) || {{ $course->oral }} == 0) {
              oral = 0; $('#oral_'+student_id).val('');
            }
            
            
            let work = $('#work_'+student_id).val(); 
            if(!(work > 0)  || {{ $course->work }} == 0) {
              work = 0; $('#work_'+student_id).val(''); 
            }
            
            let exam = $('#exam_'+student_id).val();
            if(!(exam > 0) || {{ $course->exam }} == 0) {
              exam = 0; $('#exam_'+student_id).val('');
            }

            let total = (parseInt(oral) + parseInt(work) + parseInt(exam));
            let course_total = ({{ $course->oral + $course->work + $course->exam }});

            let percentage = 
            (total > 0) ? 
                ((parseInt(total)/parseInt(course_total)) * 100).toFixed(2) + '%'
              :'';
            
            $('#total_'+student_id).html(total);
            $('#percentage_'+student_id).html(percentage);
            
            var data = $("#frm").serialize();
                data += "&student_id="+student_id;
            
            var url = $("#frm").attr("action");

            $.ajax({
                url : url ,
                data : data ,
                dataType : "json" ,
                type : "post" ,
                beforeSend : function(){
                    
                },
                success : function(data){
                    console.log(data);
                },
                error : function(error_data,exception){
                      
                    }
            });





            
          });
          
          $("input[type='text']").on("keypress", function(e) {
              /* ENTER PRESSED*/
              if (e.keyCode == 13) {
                  /* FOCUS ELEMENT */
                  var inputs = $(this).parents("form").eq(0).find(":input");
                  var idx = inputs.index(this);

                  if (idx == inputs.length - 1) {
                      inputs[0].select()
                  } else {
                      inputs[idx + 1].focus(); //  handles submit buttons
                      inputs[idx + 1].select();
                  }
                  return false;
              }
          });

          
          $.fn.formNavigation = function () {
            $(this).each(function () {
              $(this).find("input[type='text']").on('keyup', function(e) {
                switch (e.which) {
                  case 39:
                    $(this).closest('td').next().find("input[type='text']").focus(); break;
                  case 37:
                    $(this).closest('td').prev().find("input[type='text']").focus(); break;
                  case 40:
                    $(this).closest('tr').next().children().eq($(this).closest('td').index()).find("input[type='text']").focus(); break;
                  case 38:
                    $(this).closest('tr').prev().children().eq($(this).closest('td').index()).find("input[type='text']").focus(); break;
                }
              });
            });
          };


          $('#gradesTable').formNavigation();

      </script>
  @endpush

  @endif