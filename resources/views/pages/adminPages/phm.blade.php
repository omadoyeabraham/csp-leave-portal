@extends('layouts.adminFrontEnd')
@section('page-title')  Public holiday manager- LeavePortal   @endsection
@section('tab-content')

<style media="screen">
  table tbody td{
    text-align: center;
  }
</style>

  <div class="row">
      <div class="col-xs-8 col-xs-offset-2">
          <div class="panel panel-default">
              <div class="panel-heading back-blue">
                  <h3 class="section-heading ">List of Public Holidays </h3>
              </div>
              <div class="panel-body card text-center center">
                @if(session()->has('status'))
                    <div class="alert alert-success">
                       <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color: rgb(26,33,85)">&times;</a>
                       {{ session()->get('status') }}

                     </div>
                 @endif
                 <form class="" action="{{url('/processPublicHolidays')}}" method="post" id="holidaysForm" class="text-center">
                    {!! csrf_field() !!}
                    <table class="table table-striped table-responsive table-bordered">
                        <thead>
                          <tr>
                            <td></td>
                            <td>Name of holiday</td>
                            <td>Date of holiday</td>
                          </tr>
                        </thead>

                        <tbody class="table-centered">
                          @foreach($publicHolidays as $publicHoliday)
                            <tr class="text-center">
                              <td>
                                <input type="checkbox" name="publicHolidayCheckbox[]" value="{{$publicHoliday->id}}">
                              </td>
                              <td class="text-center">{{$publicHoliday->holiday_name}}</td>
                              <td class="text-center">
                                {{ date_format(date_create_from_format('Y-m-d', $publicHoliday->holiday_date), 'd-M-Y') }}
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>

                    {{-- Buttons --}}
                    <button type="button" class="btn btn-info center " data-toggle="modal"
                    data-target="#newHolidayModal">Add new holiday
                    </button>
                    <button type="button" class="btn btn-info center " data-toggle="modal"
                    data-target="#editHolidayModal">Edit Holiday
                    </button>
                    <button type="submit" class="btn btn-danger center" name="deleteHoliday"
                    form="holidaysForm">
                    Delete Holiday
                    </button>

                    <!-- MODAL FOR NEW HOLIDAY -->
                    <div id="newHolidayModal" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <!--Modal content -->
                        <div class="modal-content">

                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                             name="button">&times;</button>
                             <h3 class="modal-title">Create a new holiday</h3>
                          </div>
                          <div class="modal-body">
                              <div class="form-group">
                                <label for="holidayName">Holiday Name:</label>
                                <input type="text" name="holidayName" class="" form="holidaysForm">
                              </div>
                              <div class="form-group">
                                <label for="holidayDate">Holiday Date:</label>
                                  <input type="text" id="holidayDate" name="holidayDate" class="" form="holidaysForm">
                              </div>
                              <input type="submit" name="createHoliday" value="Create" class="btn btn-info" form="holidaysForm">
                            </form>
                          </div>

                        </div>
                      </div>
                    </div>

                    <!-- MODAL FOR editing HOLIDAY -->
                    <div id="editHolidayModal" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <!--Modal content -->
                        <div class="modal-content">

                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                             name="button">&times;</button>
                             <h3 class="modal-title">Edit the holiday</h3>
                          </div>
                          <div class="modal-body">
                              <div class="form-group">
                                <label for="holidayName">Holiday Name:</label>
                                <input type="text" name="editHolidayName" class="" form="holidaysForm">
                              </div>
                              <div class="form-group">
                                <label for="holidayDate">Holiday Date:</label>
                                  <input type="text" id="editHolidayDate" name="editHolidayDate" class="" form="holidaysForm">
                              </div>
                              <input type="submit" name="editHoliday" value="Edit" class="btn btn-info" form="holidaysForm">
                            </form>
                          </div>

                        </div>
                      </div>
                    </div>



              </div>

          </div>
      </div>
  </div>



@endsection
