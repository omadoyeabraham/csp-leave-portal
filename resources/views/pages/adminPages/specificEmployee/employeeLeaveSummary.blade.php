@extends('layouts.adminGetUserFrontEnd')
@section('page-title')  Employee leave history- LeavePortal   @endsection
@section('tab-content')

@section('tab-content')
      <div class="flex-item2 inner-content ty">
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2">
              @if(session()->has('status'))
               <div class="alert alert-success">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color: rgb(26,33,85)">&times;</a>
                  {{ session()->get('status') }}

                </div>
                @endif
                 @if(session()->has('statusDanger'))
                 <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color: rgb(26,33,85)">&times;</a>
                    {{ session()->get('statusDanger') }}

                  </div>
                  @endif

                     <div class="panel panel-default">
                         <div class="panel-heading back-blue">
                             <h3 class="section-heading">Leave Summary for {{$employee->name}}</h3>
                         </div>
                         <!--<div class="">-->
                             <table class="panel-body card table table-bordered table-responsive">
                                <tbody>
                                    <tr>
                                        <td class="w80p">Annual Eligible Days</td>
                                        <td class="w20p">{{ $employee->externalGetEligibleDays($employee->id)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Carry over balance from last FY </td>
                                        <td>{{ $employee->COD_from_last_yr }}</td>
                                    </tr>
                                    <tr>
                                        <td>Days earned till date for 2016 FY </td>
                                        <td>{{ $employee->externalGetDaysEarnedTillDate($employee->id) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Days taken in 2016 FY</td>

                                        <td>{{ $employee->no_of_leave_days_used }}</td>
                                    </tr>
                                    <tr>
                                        <td>Days available for use</td>
                                        <td>{{ $employee->COD_from_last_yr +  $employee->externalGetDaysEarnedTillDate($employee->id) - $employee->no_of_leave_days_used }}</td>
                                    </tr>

                                </tbody>
                            </table>
                         <!--</div>-->
                     </div>
                 </div>
             </div>

              <!-- Beginning of second table -->
             <div class="row">
                 <div class="col-xs-8 col-xs-offset-2">
                     <div class="panel panel-default">
                         <div class="panel-heading back-blue">
                             <h3 class="section-heading">Specific Leave Categories</h3>
                         </div>
                         <!--<div class="">-->
                         <table class="panel-body card table table-bordered table-responsive table-striped">
                           <thead>
                             <th>

                               <td>Days used</td>
                               <td>Days remaining</td>
                             </th>
                           </thead>
                            <tbody>

                                <tr>
                                    <td class="w30p">Sick Leave </td>
                                    <td class="w30p bold " style="text-align:center">{{$employee->sick_leave}}</td>
                                    <td class="w30p bold" style="text-align:center">{{3 - $employee->sick_leave}}</td>
                                </tr>
                                <tr>
                                    <td>Study/Exam Leave </td>
                                    <td class="bold" style="text-align:center">{{$employee->study_leave}}</td>
                                    <td class="w30p bold" style="text-align:center">{{5 - $employee->study_leave}}</td>
                                </tr>
                                <tr>
                                    <td>Compassionate Leave   </td>
                                    <td class="bold" style="text-align:center">{{$employee->compassionate_leave}}</td>
                                    <td class="w30p bold" style="text-align:center">{{3 - $employee->compassionate_leave}}</td>
                                </tr>
                                @if($userGender === "M")
                                <tr>
                                    <td>Paternity Leave</td>
                                    <td class="bold" style="text-align:center">{{ $employee->paternity_maternity_leave}}</td>
                                    <td class="w30p bold" style="text-align:center">{{3 - $employee->paternity_maternity_leave}}</td>
                                </tr>
                                @endif

                                @if($userGender === "F")
                                <tr>
                                    <td>Maternity Leave</td>
                                    <td class="bold" style="text-align:center">{{ $employee->paternity_maternity_leave}}</td>
                                      <td class="w30p bold" style="text-align:center">{{90 - $employee->paternity_maternity_leave}}</td>
                                </tr>
                                @endif


                            </tbody>
                        </table>
                         <!--</div>-->
                     </div>
                 </div>
             </div>
             <!-- End of second table -->

          </div>
      </div>
  </div>
@endsection
