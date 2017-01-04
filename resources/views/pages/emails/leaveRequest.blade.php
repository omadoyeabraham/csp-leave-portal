




<html>

  <p><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>New Leave request</title>
  </head></p>

  <p><body></P>
    <p><table width="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff"><tr><td></p>

      <h4 style="font-weight: 100">Dear {{$line_manager_for_this_request}},<h4>

        <p style="font-weight: 100">{{ Auth::user()->name }}  has requested for {{$noOfDays}} day(s) {{$_POST['leaveType']}} leave  from
        {{$start_date}}  to {{$end_date}}.</p>

      Please note the following:<br>

      <ul style="font-weight: 100; list-style-type: square">
        <li style="font-weight: 100">This user has {{Auth::user()->COD_from_last_yr}} carry over day(s) from his/her previous year.</li>
        <li style="font-weight: 100">This user would have accrued {{Auth::user()->getDaysEarnedTillDate()}} day(s) as at {{date("d-M-Y")}}.</li>
        <li style="font-weight: 100">Total days available to the user is {{Auth::user()->no_of_leave_days_remaining}} day(s).</li>
      </ul>

      @if($commentsByStaff == "")
            <h4 style="font-weight: 100">Reason for leave: No comment given<h4>
      @else
            <h4 style="font-weight: 100">Reason for leave: {{$commentsByStaff}}<h4>
      @endif


      <p style="font-weight: 100">Please click <a href="{{ url('/replyLeaveRequests') }}">here</a> to approve/disapprove his/her request.</p>


      Thank you.


      <p></tr></td></table><!-- wrapper --></p>

  <p></body></P>
</html>
