
@extends('layouts.adminFrontEnd')

@section('page-title') Carryover leave days    @endsection

@section('tab-content')

<div class="row">
  <div class="col-xs-8 col-xs-offset-2">
    <div class="panel panel-default">
      <div class="panel-heading back-blue">
          <h3 class="section-heading">Carry over leave days </h3>
      </div>
      <div class="panel-body card text-center center">
        @if(session()->has('status'))
            <div class="alert alert-success">
               <a href="#" class="close" data-dismiss="alert" aria-label="close" style="color: rgb(26,33,85)">&times;</a>
               {{ session()->get('status') }}
             </div>
         @endif
         <button type="button" class="btn btn-info center " data-toggle="modal"
         data-target="#carryOverLeaveModal">Carry over the leave days for all employees
         </button>

         <!-- Confirmation Modal -->
         <div id="carryOverLeaveModal" class="modal fade text-center" role="dialog">
           <div class="modal-dialog">
             <!-- Modal content-->
             <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                 <h4 class="modal-title">CarryOver leave days</h4>
               </div>
               <div class="modal-body">
                 <p>Are you sure you want to carryover outstanding leave days for all employees?</p>
                 <div class="">
                      <a href="{{url('/admin/do/carryOver')}}" class="btn btn-info"> Yes</a>
                      <button type="button" class="btn btn-danger" data-dismiss="modal"> No</button>


                 </div>
               </div>
             </div>
           </div>
         </div>
      </div>
    </div>
  </div>
</div>


@endsection
