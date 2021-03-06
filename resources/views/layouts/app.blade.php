<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CardinalStone || LeavePortal</title>

    <link rel='shortcut icon' type='image/x-icon' href="{{ URL::to('assets/img/favicon.ico') }}" />
  <!-- Fonts -->
    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>-->
    <link rel="stylesheet" href="{{ URL::to('assets/css/0-tools/font-awesome/css/font-awesome.min.css') }}" media="screen" title="no title" charset="utf-8">

    <!-- Styles -->
     <!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">-->

      <link rel="stylesheet" href="{{ URL::to('assets/css/app.css') }}">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <style>
        body {
            font-family: calibri;
        }

        .fa-btn {
            *margin-right: 6px;
        }
        .navbar-default{
          height: 60px;
          margin-bottom: 20px;
          background-color: #f8f8f8;
          background-image: none;
        }
        .login-page {
  width: 360px;
  padding: 8% 0 0;
  margin: auto;
}
.form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  *box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form input {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.form button {
  *font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background:  rgb(26,33,85);
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
.form button:hover,.form button:active,.form button:focus {
  background:  rgb(26,33,85);
}
.form .message {
  margin: 15px 0 0;
  color: #b3b3b3;
  font-size: 12px;
}
.form .message a {
  color: #4CAF50;
  text-decoration: none;
}
.form .register-form {
  display: none;
}
.container {
  position: relative;
  z-index: 1;
  max-width: 300px;
  margin: 0 auto;
}
.container:before, .container:after {
  content: "";
  display: block;
  clear: both;
}
.container .info {
  margin: 50px auto;
  text-align: center;
}
.container .info h1 {
  margin: 0 0 15px;
  padding: 0;
  font-size: 36px;
  font-weight: 300;
  color: #1a1a1a;
}
.container .info span {
  color: #4d4d4d;
  font-size: 12px;
}
.container .info span a {
  color: #000000;
  text-decoration: none;
}
.container .info span .fa {
  color: #EF3B3A;
}
body {
  *background: #76b852; /* fallback for old browsers */
  *background: -webkit-linear-gradient(right, #fff,  rgb(26,33,85) );
  *background: -moz-linear-gradient(right, #fff,  rgb(26,33,85) );
  *background: -o-linear-gradient(right,  #fff,  rgb(26,33,85));
  *background: linear-gradient(to right, #ccc, rgb(26,33,85));
  background-image: url('images/bg.jpg');
  *background-size: cover;
  background-repeat: no-repeat;
*background: rgba(26,33,85,.9);
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

    </style>
</head>
<body id="app-layout">

    <div class="container-centered">
      @yield('content')
    </div>



    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
