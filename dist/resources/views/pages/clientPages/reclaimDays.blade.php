@extends ('layouts.baseFrontEnd')

@section('page-title')  Reclaim days- LeavePortal     @endsection
@section ('tab-content')
  <div class="row">
    <div class="col-xs-8 col-xs-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading back-blue">
          <h3 class="section-heading text-center">Reclaim leave days</h3>
        </div>
        <div class="panel-body card">
       
          <p class="text-center mb30">
            Use this module to request days to be added back to your leave balance.
             This may include days you had to come back to work from leave due to line
              manager call back or unfinished tasks.
          </p>

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
          <form class="" action="{{url('/reclaimLeaveDays/'.Auth::user()->id)}}" method="post">
            {!! csrf_field() !!}
            <div class="form-group">
              <label for="noOfDays" class="blue-item">No of days</label>
              <input type="number" min="1" name="noOfDays" id="noOfDays" class="form-control w40p" required>
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
              <label for="reason" class="blue-item">Reason for reclaiming</label>
              <textarea name="reason" rows="8" cols="20" class="form-control" required></textarea>
            </div>
            <input type="submit" name="reclaim" value="Reclaim Days" class="btn btn-info center">
          </form>
        </div>
      </div>
    </div>
  </div>



@stop
