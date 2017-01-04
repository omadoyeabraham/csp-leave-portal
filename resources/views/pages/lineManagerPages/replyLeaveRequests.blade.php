@extends('layouts.baseFrontEnd')
@section('page-title')  Reply leave requests- LeavePortal   @endsection
@section('tab-content')

	<div class="row">
        <div class="col-xs-10 col-xs-offset-1">
          <div class="panel panel-default">
            <div class="panel-heading back-blue">
              <h3 class="section-heading">Respond to leave requests</h3>
            </div>
            <div class="panel-body card">
							@if(session()->has('statusDanger'))
							<div class="alert alert-danger">
								 <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color: rgb(26,33,85)">&times;</a>
								 {{ session()->get('statusDanger') }}

							 </div>
							 @endif
							 @if(session()->has('status'))
							 <div class="alert alert-success">
									<a href="#" class="close" data-dismiss="alert" aria-label="close" style="color: rgb(26,33,85)">&times;</a>
									{{ session()->get('status') }}

								</div>
								@endif

					<!--Form that handles approval/disapproval of leave requets -->
					<form method="POST" action="{{url('/processLeaveRequests')}}" id="replyLeaveForm" name="replyLeaveForm">
						  {!! csrf_field() !!}
              <table class=" table table-bordered table-responsive table-centered table-striped">
                <thead>
                  <tr>
					<td></td>
                    <td>Staff</td>
                    <td>Application Date</td>
                    <td>Leave Type</td>
                    <td>Duration</td>
					<td>No of days </td>
					<td>C.O.D from last year</td>
					<td>Leave days earned <!--in {{date("Y")}}--> </td>
                  </tr>
                </thead>

                <tbody>
										@foreach($leaveRequests as $leaveRequest)
											<tr class="table-text-center">
													<td><input type="checkbox" name="leaveRequestcheckbox[]" value="{{$leaveRequest->id}}"></td>
													<td class="w15p">{{$leaveRequest->staff_name}}</td>
													<td>{{$leaveRequest->date_applied}}</td>
													<td>{{$leaveRequest->leave_type}}</td>

													@if($leaveRequest->leave_type === 'Reclaim Request')
														<td>N/A</td>
													@else
														<td class="w25p">
															{{ date_format(date_create_from_format('Y-m-d', $leaveRequest->start_date), 'd-M-Y') }}
															---
															{{  date_format(date_create_from_format('Y-m-d', $leaveRequest->end_date), 'd-M-Y')  }}
														</td>
													@endif

													<td>{{$leaveRequest->no_of_days}}</td>
													<td>{{$leaveRequest->COD_from_last_yr}}</td>
													<td>{{$leaveRequest->days_gained_this_yr}}</td>

											</tr>
										@endforeach
                </tbody>
              </table>
							<div class="row">
								<div class="col-xs-8 col-xs-offset-2 text-center">
									<button type="button" name="button" class="btn btn-info" data-toggle="modal" data-target="#approveLeaveModal">Approve</button>
									<button type="button" name="button" class="btn btn-danger" data-toggle="modal" data-target="#disapproveLeaveModal">Disapprove</button>
								</div>
							</div>
						</form>

												<!-- Modal -->
										<div id="approveLeaveModal" class="modal fade" role="dialog">
											<div class="modal-dialog">

											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title text-center">Comments</h4>
												</div>
												<div class="modal-body form-group">
													<textarea name="commentsByLineManager" rows="6" cols="30" class="center block form-control" form="replyLeaveForm"></textarea>
													<input type="submit" name="approveLeaveRequest" class="btn btn-info center mt20" value="Approve" form="replyLeaveForm">
												</div>

											</div>

											</div>
										</div>

										<!-- Disapprove leave Modal -->
								<div id="disapproveLeaveModal" class="modal fade" role="dialog">
									<div class="modal-dialog">

									<!-- Modal content-->
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title text-center">Comments</h4>
										</div>
										<div class="modal-body form-group">
											<textarea name="commentsByLineManager" rows="6" cols="30" class="center block form-control" form="replyLeaveForm"></textarea>
											<input type="submit" name="disapproveLeaveRequest" class="btn btn-info center mt20" value="Disapprove" form="replyLeaveForm">
										</div>

									</div>

									</div>
								</div>

            </div>
          </div>
        </div>
      </div>

@endsection
