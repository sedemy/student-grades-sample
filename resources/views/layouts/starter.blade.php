@extends('layouts.master')

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1></h1>
      
      <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-header with-border">
              
            </div>
            <div class="box-body text-center">
            <a class="btn btn-success" href="{{url('grades')}}">
                Go to Grades Spread Sheet
              </a>
            </div>
            <div class="box-header with-border">
              
              </div>
          </div>
        </div>

        
    </section>
    <!-- Main content -->
    <section class="content container-fluid"></section>
  <!-- /.content -->
@endsection
