<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('page-title')</title>

    <link rel='shortcut icon' type='image/x-icon' href="{{ URL::to('assets/img/favicon.ico') }}" />
	<!-- Fonts -->
    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>-->
    <link rel="stylesheet" href="{{ URL::to('assets/css/0-tools/font-awesome/css/font-awesome.min.css') }}" media="screen" title="no title" charset="utf-8">

    <!-- Styles -->
     <!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">-->
	   <link rel="stylesheet" href="{{ URL::to('assets/css/0-tools/jquery.datetimepicker.css') }}">
      <link rel="stylesheet" href="{{ URL::to('assets/css/app.css') }}">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

</head>
<body id="app-layout">
	 <nav class="navbar navbar-default navbar-me navbar-static-top w100p">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <ul class="nav navbar-nav ">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <!--<li><a href="{{ url('/login') }}">Login</a></li>-->
                        <!--<li><a href="{{ url('/register') }}">Register</a></li>-->
                        <li class="dropdown">
                            <h4 style="color:red">This user is a guest</h4>
                            <h4>   {{ Auth::user()}} </h4>
                        </li>

                    @else
                        <li class="dropdown">
                            <span href="#" class="dropdown-toggle* welcome " data-toggle="dropdown" role="button" aria-expanded="false">
                              Welcome,<span style="font-weight:bold; font-size:1.4em;">  {{ Auth::user()->name }}</span> <!--span class="caret"></span> -->
                            </span>

                            <!--<ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul> -->
                        </li>
                      <span class="welcome">
                        <a href="{{ url('/logout') }}" style="color:rgb(230,28,35); position:relative;text-align:left" class="logout"><i class="fa fa-btn fa-sign-out" style="color:rgb(230,28,35);"></i>Logout</a>
                      </span>


                    @endif
                </ul>

            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <!--<ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                </ul>-->

                <!-- Right Side Of Navbar -->
                <div class="nav navbar-nav navbar-right">
                  <!-- Branding Image -->
                  <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{url('assets/img/logo.png')}}" alt="cardinalstone logo" class="w12p  logo"  height="40px"/>
                  </a>
                </div>

            </div>
        </div>
    </nav>

    <div class="main-container">
			<div class="content">
					<div class="flex-item sidebar text-center">
						<a href="{{url('/summary')}}" class="btn-sidebar btn-one"><i class="fa fa-th pull-left" aria-hidden="true"></i>&nbsp;<span>Leave summary</span></a>
						<a href="{{url('/applyForLeave/'. Auth::user()->id )}}" class="btn-sidebar" ><i class="fa fa-pencil pull-left fa-fw" aria-hidden="true"></i>&nbsp;<span>Apply for leave</span></a>
						<a href="{{url('/requestStatus/'.Auth::user()->id)}}" class="btn-sidebar" ><i class="fa fa-table pull-left" aria-hidden="true"></i>&nbsp;<span>View request status</span></a>
						<a href="{{url('/reclaimDays')}}" class="btn-sidebar" ><i class="fa fa-recycle pull-left" aria-hidden="true"></i><span>Reclaim leave days</span></a>
						<a href="{{url('/leavePolicy')}}" class="btn-sidebar" ><i class="fa fa-book pull-left" aria-hidden="true"></i>&nbsp;&nbsp;<span>Leave Policy</span></a>

            @if( (Auth::user()->isLineManager()) )
            <a href="{{url('/replyLeaveRequests')}}" class="btn-sidebar"><i class="fa fa-reply-all pull-left" aria-hidden="true"></i><span>Respond to Requests</span></a>
           @endif
            @if( !(Auth::user()->isAdmin()) )
            <a href="{{url('/phm')}}" class="btn-sidebar" target="_blank"><i class="fa fa-user pull-left" aria-hidden="true"></i><span>Admin Page</span></a>
            @endif
            <!--<a href="javascript:void(0);" class="icon" onclick="togglenav()">&#9776;</a>-->
					</div>
					<div class="flex-item inner-content">
						@yield('tab-content')
					</div>
			</div>
  	</div>


	   <!-- JavaScripts
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script rel="stylesheet" src="{{ URL::to('assets/js/jquery.datetimepicker.full.min.js') }}"></script>
  <script  src="{{ URL::to('assets/js/moment.js') }}"></script>
	<script rel="stylesheet" src="{{ URL::to('assets/js/dates.js') }}"></script>
  <script rel="stylesheet" src="{{ URL::to('assets/js/main.js') }}"></script>

   JavaScripts -->



<script rel="stylesheet" src="{{ URL::to('assets/js/jquery.min.js') }}"></script>
 <script rel="stylesheet" src="{{ URL::to('assets/js/bootstrap.min.js') }}"></script>
 <script rel="stylesheet" src="{{ URL::to('assets/js/jquery.datetimepicker.full.min.js') }}"></script>
   <script  src="{{ URL::to('assets/js/moment.js') }}"></script>
<script rel="stylesheet" src="{{ URL::to('assets/js/jqueryDataTables.min.js') }}"></script>
 <!--script rel="stylesheet" src="{{ URL::to('assets/js/dates2.js') }}"></script-->
 <script rel="stylesheet" src="{{ URL::to('assets/js/dates3.js') }}"></script>
 <script rel="stylesheet" src="{{ URL::to('assets/js/main.js') }}"></script>
 <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.css">
 <script type="text/javascript"  src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.js"></script>
 <script rel="stylesheet" src="{{ URL::to('assets/js/dataTables.bootstrap.min.js') }}"></script>
 <script rel="stylesheet" src="{{ URL::to('assets/js/dataTables.js') }}"></script>


 {{-- <script src="{{ elixir('assets/js/app.js') }}"></script> --}}

    {{-- <script src="{{ elixir('assets/js/app.js') }}"></script> --}}

</body>
<script>

</script>
</html>
