@extends('layouts.adminFrontEnd')
@section('page-title')  Employee leave details- LeavePortal   @endsection
@section('tab-content')


<div class="row">
  <div class="col-xs-12 m10 ">
    <div class="panel panel-default">
      <div class="panel-heading back-blue">
        <h3 class="section-heading">Employee Leave Datacenter</h3>
      </div>
      <div class="panel-body card">
        <table class="table table-striped  table-bordered table-centered" id="dataTable">
          <thead>
              <tr>
                <th>Staff Name</th>
                <th>Annual Eligible Days</th>
                <th>C.O.D into {{date("Y")}} </th>
                <th>Days earned in {{date("Y")}}</th>
                <th>Days used in {{date("Y")}}</th>
                <th>Leave days remaining </th>
              </tr>
          </thead>
          <tbody>
              @foreach($allUsers as $singleUser)
                <tr>
                  <td><a href="adminGetUser/{{$singleUser->id}}" style="color:black">{{$singleUser->name}}</a></td>
                  <td>{{$singleUser->externalGetEligibleDays($singleUser->id)}}</td>
                  <td>{{$singleUser->COD_from_last_yr}}</td>
                  <td>{{$singleUser->externalGetDaysEarnedTillDate($singleUser->id)}}</td>
                  <td>{{$singleUser->no_of_leave_days_used}}</td>
                  <td>{{$singleUser->COD_from_last_yr + $singleUser->externalGetDaysEarnedTillDate($singleUser->id) - $singleUser->no_of_leave_days_used }}</td>
                </tr>
              @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>


@endsection
