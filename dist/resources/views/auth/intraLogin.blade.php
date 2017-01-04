<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CardinalStone Partners - Leave Portal</title>

<link href="class/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="825" border="0" align="center" cellpadding="0" cellspacing="0" class="roundedcorner border">
  <tr>
    <td height="10" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td width="825" height="400" align="center" valign="top" class="" style="background:url(images/login_bg.jpg); background-repeat:no-repeat;"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="">
      <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
          {!! csrf_field() !!}
        <tr>
        <td height="40" colspan="2" align="center" valign="middle" class="white medium padleft">&nbsp;</td>
      </tr>
      <tr>
        <td rowspan="3" align="left" valign="middle" class="black bold large padleft"><img src="images/logo.jpg" width="205" height="66" class="imagelink" /></td>
        <td height="35" align="left" valign="middle" class="black bold large padleft">&nbsp;</td>
      </tr>
      <tr>
        <td height="35" align="center" valign="middle" class="white medium padleft">&nbsp;</td>
      </tr>
      <tr>
        <td height="35" align="left" valign="middle"></td>
      </tr>
      <tr>
        <td height="35" colspan="2" align="left" valign="middle" class="huge darkblue padleft">
        Leave Portal                  </td>
      </tr>
      <tr>
        <td height="35" align="center" valign="middle" class="padleft large bold white">&nbsp;</td>
        <td height="35" align="left" valign="middle" class="large white">
       <strong> Staff Login </strong>
     </td>
   </tr>
   <tr>
     <td width="200" height="35" align="right" valign="middle" class="white medium bold padright">Username</td>
     <td width="245" height="35" align="left">
       <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">


           <div class="">
               <input type="text" class="form-control" name="username" value="{{ old('username') }}">

               @if ($errors->has('username'))
                   <span class="help-block">
                       <strong style="color:red">{{ $errors->first('username') }}</strong>
                   </span>
               @endif
           </div>
       </div><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
       <html xmlns="http://www.w3.org/1999/xhtml">
       <head>
       <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
       <title>CardinalStone Partners - Leave Portal</title>

       <link href="class/style.css" rel="stylesheet" type="text/css" />
       </head>

       <body>
       <p>&nbsp;</p>
       <p>&nbsp;</p>
       <p>&nbsp;</p>
       <table width="825" border="0" align="center" cellpadding="0" cellspacing="0" class="roundedcorner border">
         <tr>
           <td height="10" align="left" valign="middle">&nbsp;</td>
         </tr>
         <tr>
           <td width="825" height="400" align="center" valign="top" class="" style="background:url(images/login_bg.jpg); background-repeat:no-repeat;"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="">
             <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                 {!! csrf_field() !!}
               <tr>
               <td height="40" colspan="2" align="center" valign="middle" class="white medium padleft">&nbsp;</td>
             </tr>
             <tr>
               <td rowspan="3" align="left" valign="middle" class="black bold large padleft"><img src="images/logo.jpg" width="205" height="66" class="imagelink" /></td>
               <td height="35" align="left" valign="middle" class="black bold large padleft">&nbsp;</td>
             </tr>
             <tr>
               <td height="35" align="center" valign="middle" class="white medium padleft">&nbsp;</td>
             </tr>
             <tr>
               <td height="35" align="left" valign="middle"></td>
             </tr>
             <tr>
               <td height="35" colspan="2" align="left" valign="middle" class="huge darkblue padleft">
               Leave Portal                  </td>
             </tr>
             <tr>
               <td height="35" align="center" valign="middle" class="padleft large bold white">&nbsp;</td>
               <td height="35" align="left" valign="middle" class="large white">
              <strong> Staff Login </strong>
            </td>
          </tr>
          <tr>
            <td width="200" height="35" align="right" valign="middle" class="white medium bold padright">Username</td>
            <td width="245" height="35" align="left">
              <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">


                  <div class="">
                      <input type="text" class="form-control" name="username" value="{{ old('username') }}">

                      @if ($errors->has('username'))
                          <span class="help-block">
                              <strong style="color:red">{{ $errors->first('username') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>
              </td>
            </tr>
            <tr>
              <td height="35" align="right" valign="middle" class="white medium bold padright">Password</td>
              <td height="35" align="left">
                  <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                                   <div class="col-md-6">
                                         <label class="control-label" style="display:block; margin-top: 10px">
                                              @if ($errors->has('password'))
                                                 <span class="help-block">
                                                     <strong style="color:red; position:fixed; top:70%;left:50%">{{ $errors->first('password') }}</strong>
                                                 </span>
                                             @endif
                                         </label>

                                   </div>
                                   <input type="password" class="form-control" name="password" value="{{ old('password') }}">
                     </div>
              </td>
            </tr>
            <tr>
              <td height="35" align="right" class="sitefont white medium bold padright">&nbsp;</td>


               </td>
              <td height="35" align="left"><input type='submit' name='submit' value='Login' /></td>
            </tr>
            <tr>
              <td height="35" colspan="2" align="center" valign="middle" class="darkblue medium sitefont">&nbsp;</td>
            </tr>
       </form>
       </table>
       </td>
       </tr>
       <tr>
       <td height="40" align="right" valign="middle" class="padright darkash small">&copy; Copyright <?php echo date('Y') ?>. CardinalStone Partners. All Rights Reserved</td>
       </tr>
       </table>
       </body>
       </html>

       </td>
     </tr>
     <tr>
       <td height="35" align="right" valign="middle" class="white medium bold padright">Password</td>
       <td height="35" align="left">
           <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                            <div class="col-md-6">
                                  <label class="control-label" style="display:block; margin-top: 10px">
                                       @if ($errors->has('password'))
                                          <span class="help-block">
                                              <strong style="color:red">{{ $errors->first('password') }}</strong>
                                          </span>
                                      @endif
                                  </label>
                                <input type="password" class="form-control" name="password" value="{{ old('password') }}">
                            </div>
              </div>
       </td>
     </tr>
     <tr>
       <td height="35" align="right" class="sitefont white medium bold padright">&nbsp;</td>
       <td height="35" align="left"><input type='submit' name='submit' value='Login' /></td>
     </tr>
     <tr>
       <td height="35" colspan="2" align="center" valign="middle" class="darkblue medium sitefont">&nbsp;</td>
     </tr>
</form>
</table>
</td>
</tr>
<tr>
<td height="40" align="right" valign="middle" class="padright darkash small">&copy; Copyright <?php echo date('Y') ?>. CardinalStone Partners. All Rights Reserved</td>
</tr>
</table>
</body>
</html>
