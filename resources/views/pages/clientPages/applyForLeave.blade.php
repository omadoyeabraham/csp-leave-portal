@extends ('layouts.baseFrontEnd')

@section('page-title')  Apply for leave- LeavePortal   @endsection
@section('tab-content')

<div class="row">
   <div class="col-xs-12 col-xs-offset-1 col-md-10 col-md-offset-1">
      <div class="panel panel-default">
				<div class="panel-heading back-blue">
						<h3 class="section-heading text-center">Apply for leave</h3>
				</div>
				<div class="panel-body card">
          @if(session()->has('statusDanger') )
          <div class="alert alert-danger">
             <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color: rgb(26,33,85)">&times;</a>
             {{ session('statusDanger') }}

           </div>
           @endif
         

           @if(session()->has('status'))
           <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color: rgb(26,33,85)">&times;</a>
              {{ session()->get('status') }}

            </div>
            @endif
            
            @if(!$bioDataIsComplete || !$userIsConfirmed)
                <h5>You are currently unable to apply for leave due to the following reason(s)</h5>
              <ul>
                  @if(!$bioDataIsComplete)
                       <li>
                             Incomplete Bio data on the intranet. Please fill the form <a href="http://{{$intranetLink}}" style="color:blue" target="_blank">here.</a>
                       </li>
                  @endif
                  @if(!$userIsConfirmed)
                        <li>
                            You have not yet been confirmed.
                        </li>
                  @endif
                 
              </ul>

            @else
                  <form  method="POST" action="postLeaveRequest/{{Auth::user()->id}}" role="form">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="leaveType" class="blue-item">Leave Type</label><br>
                        <select id="leaveType" name="leaveType" value="{{ old('leaveType') }}" class="form-control w25p" required="true">
                           @foreach ($leaveTypes as $leaveType)


                                  @if( old('leaveType') == $leaveType)
                                  <option value="{{$leaveType}}" selected="true"> {{$leaveType}}

                                  </option>
                                  @else
                                      <option value="{{$leaveType}}"> {{$leaveType}}

                                      </option>
                                  @endif


                           @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="leaveDuration" class="blue-item">Leave Duration</label><br>
                        <input type="text" id="startDate" name="startDate" value="{{ old('startDate') }}" class="form-control w25p pull-left" placeholder="Start date" onchange= "ajaxCalcDate()" required="true" autocomplete="off"> <span class="pull-left m5 blue-item" >To</span>
                        <input type="text" id="endDate" name= "endDate" value="{{ old('endDate') }}" class="form-control w25p pull-left" placeholder="End Date" onchange= "ajaxCalcDate()" required="true" autocomplete="off">
                        <label for="noOfDays" class="pull-left m5 ml20 blue-item">No of days</label>
                        <input type="text" id="noOfDays" name="noOfDays"  class="form-control w30p pull-left" placeholder="No of days" readonly="true"><br>
                        <!--<div class="error">
                            <p class="pull-right w40p">You have exceeded your maximum no of days allowed</p>
                        </div>-->
                    </div>
                    <div class="form-group">
                        <label for="lineManager" class="mt10 blue-item">Line Manager</label><br>
                        <select id="lineManager" name="lineManager" class="form-control w40p" required="true">



                              @if(isset($lineManagersList))

                                  @for($x = 0; $x < (int)$counter; $x++)
                                      @if($x === 0)
                                        <option value="{{ $lineManagersList[$x] }}">
                                            {{$lineManagersList[$x]}} (Default)
                                        </option>
                                        @else
                                        <option value="{{$lineManagersList[$x]}}">
                                            {{$lineManagersList[$x]}}
                                        </option>

                                      @endif
                                  @endfor
                              @endif



                        </select>

                    </div>
                    <div class="form-group">
                        <label for="comments" class="blue-item">Comments/Reason</label><br>
                        <textarea name="comments" id="comments" cols="10" rows="5" class="form-control"></textarea>
                    </div>
                    <input type="submit" name="apply" value="Apply" class="btn btn-info">
                </form>

            @endif


					` 
				</div>
			</div>


   </div>
</div>



@stop
@include('footer')
