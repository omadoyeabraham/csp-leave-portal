<html>

  <p><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>New Leave request</title>
  </head></p>

  <p><body></P>
    <p><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff"><tr><td></p>

      <h4 style="font-weight: 100">Dear {{$line_manager_for_this_request}},<h4>

        <p style="font-weight: 100">{{ Auth::user()->name }}  has made a request to reclaim {{$noOfDays}} previously approved leave day(s) </p>

      <h4 style="font-weight: 100">Reason for reclaim request: {{$commentsByStaff}}<h4>


      <p style="font-weight: 100">Please click <a href="{{ url('/replyLeaveRequests') }}">here</a> to approve/disapprove his/her request.</p>

      Thank you.


      <p></tr></td></table><!-- wrapper --></p>

  <p></body></P>
</html>
