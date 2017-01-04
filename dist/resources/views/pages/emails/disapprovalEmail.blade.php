<html>

  <p><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Leave request disapproval</title>
  </head></p>

  <p><body></P>
    <p><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff"><tr><td></p>

      <h4 style="font-weight: 100">Dear {{ $staffName }},<h4>

        <p style="font-weight: 100">Please be informed that your leave request ({{$leaveType}})
        from {{$startDate}} to {{$endDate}} has been disapproved.</p>


      {{-- <h4 style="font-weight: 100">Reason given by line manager :


            @if(isset($commentsByLineManager))
              {{$commentsByLineManager}}
            @else
                No comments given
            @endif



        <h4>
 --}}

      Thank you.


      <p></tr></td></table><!-- wrapper --></p>

  <p></body></P>
</html>
