@extends('layouts.adminGetUserFrontEnd')
@section('page-title')  Confirm Employee- LeavePortal   @endsection
@section('tab-content')
  <div class="row">
    <div class="col-xs-10 col-xs-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading back-blue">
          <h3 class="section-heading text-center">Confirmation Status</h3>
        </div>
        <div class="panel-body card text-center">
          @if(session()->has('status'))
          <div class="alert alert-success">
             <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color: rgb(26,33,85)">&times;</a>
             {{ session()->get('status') }}

           </div>
           @endif

          @if($employee->confirmation_status == 1)
            <div class="well">
              {{$employee->name}} is a <span style="color:green">CONFIRMED</span> employee.
            </div>
          @else
            <div class="well">
                {{$employee->name}} is an <span style="color:red">UNCONFIRMED</span> employee.
            </div>

          @endif
              <div class="text-center mt30">
                  <form class="text-center" action="{{url('/processEmployeeConfirmation' ,array( session()->get('adminEmployeeId') ) ) }}" method="post" id="confirmationForm">
                    {!! csrf_field() !!}
                    <button type="button" class="btn btn-info " data-toggle="modal" data-target="#confirmModal">Confirm Employee</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#unconfirmModal">Unconfirm Employee</button>
                  </form>
              </div>

              <!-- Confirmation Modal -->
              <div id="confirmModal" class="modal fade text-center" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Confirm {{$employee->name}}</h4>
                    </div>
                    <div class="modal-body">
                      <p>Are you sure you want to confirm this employee?</p>
                      <div class="">
                          <input type="submit" name="confirmEmployee" value="Yes" class="btn btn-info" form="confirmationForm">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- UnConfirmation Modal -->
              <div id="unconfirmModal" class="modal fade text-center" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Unconfirm {{$employee->name}}</h4>
                    </div>
                    <div class="modal-body">
                      <p>Are you sure you want to unconfirm this employee?</p>
                      <div class="">
                          <input type="submit" name="unconfirmEmployee" value="Yes" class="btn btn-info" form="confirmationForm">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

        </div>
      </div>
    </div>
  </div>
@endsection
