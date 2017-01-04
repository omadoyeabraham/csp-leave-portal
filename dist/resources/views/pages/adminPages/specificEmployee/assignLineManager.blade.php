@extends('layouts.adminGetUserFrontEnd')
@section('page-title')  Assign line manager- LeavePortal   @endsection
@section('tab-content')
  <div class="row">
    <div class="col-xs-8 col-xs-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading back-blue">
            <h3 class="section-heading ">Assign LineManager</h3>
        </div>
        <div class="panel-body card">
          @if(session()->has('status'))
          <div class="alert alert-success">
             <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color: rgb(26,33,85)">&times;</a>
             {{ session()->get('status') }}

           </div>
           @endif
           @if($employee->line_manager == "default")
             <div class="well text-center">
               <h4>{{$employee->name}}'s current line manager is the<span class="bold"> unit head</span>.</h4>
             </div>
           @else
             <div class="well text-center">
               <h4>{{$employee->name}}'s current line manager is <span class="bold">{{$employee->line_manager}}</span>.</h4>
             </div>
           @endif
          <div class="form-group text-center">
            <form class="" action="{{url('/assignLineManager', array(session()->get('adminEmployeeId')) )}}" method="post">
              {!! csrf_field() !!}
              <label for="selectLineManager">Select the new linemanager</label>
              <select class="form-control w40p center" id="selectLinemanager" name="lineManager">
                <option></option>
                @foreach($allPossibleLineManagers as $key => $value)
                    <option value="{{$value}}">{{$value}}</option>
                @endforeach
              </select>
              <div class="form-group text-center">
                <input type="submit" name="assignLineManager" value="Assign" class="btn btn-info center mt20">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
