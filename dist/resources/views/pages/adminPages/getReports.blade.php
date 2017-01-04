@extends ('layouts.AdminFrontEnd')

@section('tab-content')

<div class="row">
    <div class="col-xs-12 ">
       <div class="panel panel-default">
           <div class="panel-heading back-gray">
               <h3 class="section-heading text-center color-blue">Staff leave summary 2016</h3>
           </div>
           <div class="panel-body card">
               <table class="table table-responsive table-striped table-bordered table-gray mt20" id="staffSummaryTable">
                    <thead>
                      <tr class="back-blue">
                          <th>Employee Name</th>
                          <th>Annual Eligible days</th>
                          <th>Actual C/O into 2016</th>
                          <th>C/O days used</th>
                          <th>Current C/O balance</th>
                          <th>Days Earned Till Date for 2016</th>
                          <th>Days taken in 2016</th>
                          <th>Sick leave</th>
                          <th>Mat/paternity leave</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>

                          <td>Omadoye Abraham</td>
                          <td>15</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                      </tr>
                      <tr>

                          <td>John Snow</td>
                          <td>40</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                      </tr>
                      <tr>

                          <td>Saraki</td>
                          <td>-23</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                      </tr>
                    </tbody>
              </table>
           </div>
       </div>

    </div>
</div>

@endsection
