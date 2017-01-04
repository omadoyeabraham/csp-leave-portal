@extends('layouts.adminFrontEnd')
@section('page-title')  Add_subtract leave days- LeavePortal   @endsection

@section('tab-content')

	<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading  back-blue">
          <h3 class="section-heading text-center">Add/Subtract leave days to/from a user</h3>
        </div>
        <div class="panel-body card text-center">
          <form action="">

            <div class="form-group text-center">
              <!--<label for="staff" class="">Select staff:</label>-->
              <select name="" id="staff" class="form-control w30p pull-left">
                <option value="">Select staff</option>
                <option value="">All Staff</option>
                <option value="">Person1</option>
                <option value="">Person2</option>
              </select>
            </div>
            <div class="form-group text-center">
              <!--<label for="noOfDays">Number of days:</label>-->
              <input type="text" id="noOfDays" class="form-control w30p pull-left ml20" placeholder="No of days">
            </div>
            <input type="submit" value="Add Days " class="btn btn-info pull-down">
            <input type="submit" value="Remove Days" class="btn btn-danger">
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
