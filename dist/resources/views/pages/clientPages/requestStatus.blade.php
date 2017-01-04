@extends ('layouts.baseFrontEnd')

@section('page-title')  Request status- LeavePortal     @endsection
@section ('tab-content')





      <div class="row">
        <div class="col-xs-12 ml10 mr10">
          <div class="panel panel-default">
            <div class="panel-heading back-blue">
              <h3 class="section-heading">Requests Status</h3>
            </div>
            <div class="panel-body card">
              @if(count($requests) > 0)

              <table class="table table-striped table-responsive table-bordered">
                <thead>
                  <tr>
                    <!--<td>S/N</td>-->
                    <td>Application Date</td>
                    <td>Period</td>
                    <td>Type of leave</td>
                    <td>Duration</td>
                    <td>Line Manager</td>
                    <td>Status</td>
                  </tr>
                </thead>
                <tbody >
                    @foreach($requests as $request)
                    <tr >
                      <td style="text-align:center">{{$request->date_applied}}</td>
                      @if($request->leave_type === 'Reclaim Request')
                        <td style="text-align:center">N/A</td>

                      @else
                        <td class="w25p" style="text-align:center">
                          {{ date_format(date_create_from_format('Y-m-d', $request->start_date), 'd-M-Y') }}
                          ---
                          {{  date_format(date_create_from_format('Y-m-d', $request->end_date), 'd-M-Y')  }}
                        </td>
                      @endif
                      <td style="text-align:center">{{$request->leave_type}}</td>
                      <td style="text-align:center">{{$request->no_of_days}} day(s)</td>
                      <td style="text-align:center">{{$request->line_manager}}</td>
                      @if($request->application_status === 'pending')
                      <td style="text-align:center; color:black">{{$request->application_status}}</td>
                      @endif
                      @if($request->application_status === 'approved')
                      <td style="text-align:center; color:green">{{$request->application_status}}</td>
                      @endif
                      @if($request->application_status === 'disapproved')
                      <td style="text-align:center; color:red">{{$request->application_status}}</td>
                      @endif

                    </tr>

                    @endforeach
                </tbody>
              </table>

              @else

              <h4>You have no leave requests currently.</h4>

              @endif

            </div>
          </div>
        </div>
      </div>
{{-- <pre>{{ print_r($users)}}</pre> --}}
{{-- <pre>{{ var_dump($inserting)}}</pre> --}}


@stop
