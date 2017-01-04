


@extends('layouts.baseFrontEnd')
@section('page-title')  Summary- LeavePortal    @endsection
@section('tab-content')
      <div class="flex-item2 inner-content">
          <div class="row">

                 <div class=" col-sm-10 col-sm-offset-1">

                   @if(session()->has('status'))
                   <div class="alert alert-success">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color: rgb(26,33,85)">&times;</a>
                      {{ session()->get('status') }}

                    </div>
                    @endif
                    @if(session()->has('status2'))
                    <div class="alert alert-success">
                       <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color: rgb(26,33,85)">&times;</a>
                       {{ session()->get('status2') }}

                     </div>
                     @endif
                     @if(session()->has('statusDanger'))
                     <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color: rgb(26,33,85)">&times;</a>
                        {{ session()->get('statusDanger') }}

                      </div>
                      @endif

                     <div class="panel panel-default mb50">
                         <div class="panel-heading card-heading back-blue">
                             <h3 class="section-heading">Leave Summary for {{Date("Y")}}</h3>
                         </div>
                         <!--<div class="">-->
                             <table class="panel-body card table table-bordered table-responsive table-striped ">
                                <tbody>
                                    <tr>
                                        <td class="w80p">Annual Eligible Days</td>
                                        <td class="w20p bold">{{ $annualEligibledays }}</td>
                                    </tr>
                                    <tr>
                                        <td>Carry over balance from last FY </td>
                                        <td class="bold">{{ $carryOverDays }}</td>
                                    </tr>
                                    <tr>
                                        <td>Days earned till date  </td>
                                        <td class="bold">{{ $daysEarnedTillDate }}</td>
                                    </tr>
                                    <tr>
                                        <td>Days taken </td>
                                        <td class="bold">{{ $daysTaken }}</td>
                                    </tr>
                                    <tr>
                                        <td>Days available for use</td>
                                        <td class="bold">{{ $daysAvailableForUse }}</td>
                                    </tr>

                                </tbody>
                            </table>
                         <!--</div>-->
                     </div>
                 </div>
             </div>

              <!-- Beginning of second table -->
             <div class="row">
                 <div class=" col-sm-10 col-sm-offset-1">
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
                                        <td class="w30p bold " style="text-align:center">{{$sickLeaveDays}}</td>
                                        <td class="w30p bold" style="text-align:center">{{3 - $sickLeaveDays}}</td>
                                    </tr>
                                    <tr>
                                        <td>Study/Exam Leave </td>
                                        <td class="bold" style="text-align:center">{{$studyLeaveDays}}</td>
                                        <td class="w30p bold" style="text-align:center">{{5 - $studyLeaveDays}}</td>
                                    </tr>
                                    <tr>
                                        <td>Compassionate Leave   </td>
                                        <td class="bold" style="text-align:center">{{$compassionateLeaveDays}}</td>
                                        <td class="w30p bold" style="text-align:center">{{3 - $compassionateLeaveDays}}</td>
                                    </tr>
                                    @if($userGender === "M")
                                    <tr>
                                        <td>Paternity Leave</td>
                                        <td class="bold" style="text-align:center">{{ $paternityMaternityLeaveDays}}</td>
                                        <td class="w30p bold" style="text-align:center">{{3 - $paternityMaternityLeaveDays}}</td>
                                    </tr>
                                    @endif

                                    @if($userGender === "F")
                                    <tr>
                                        <td>Maternity Leave</td>
                                        <td class="bold" style="text-align:center">{{ $paternityMaternityLeaveDays}}</td>
                                          <td class="w30p bold" style="text-align:center">{{90 - $paternityMaternityLeaveDays}}</td>
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
  </div >
@endsection
