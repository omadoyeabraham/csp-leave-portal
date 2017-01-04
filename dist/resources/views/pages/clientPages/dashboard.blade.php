@extends('layouts.app')
@extends('layouts.baseFrontEnd')

@section('content2')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                  Hi {{ Auth::user()->name }} you are now logged in. Enjoy your day
                 {{--  {{ var_dump( Auth::user() ) }} --}}
                  
                  
                  <div class="">
                    
                  </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
