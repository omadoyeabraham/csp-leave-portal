<?php

namespace App;
use Mail;
use Auth;
use App\User;
use App\Employee;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
  /**
   * Name of the table that is bound to the User Model.
   * @var string
   */
    protected $table = 'dbo.LEAVE_REQUESTS';
    public $mailSuccess;

    		/**
    		 * Used to send a disapproved leaveRequest email
    		 * @param  [type] $user    [description]
    		 * @param  [type] $Emp_id  [description]
    		 * @param  [type] $request [HTML request from when LM clicks approval form]
    		 * @return [type]          [boolean , true on success and vice versa]
    		 */
		    public function sendDisapprovalEmail( $Emp_id, $request)
		    {
		    	$userEmail = Employee::find($Emp_id)->Emp_Email;
		                    Mail::send('pages.emails.disapprovalEmail', ['staffName' => $this->staff_name,
		                                                   'leaveType' => $this->leave_type,
		                                                   'startDate' => $this->start_date,
		                                                   'endDate'   => $this->end_date,
		                                                   'comments'  => $request->commentsByLineManager,
		                       ], function($message) use ($userEmail) {
		                           $message->from('leave@cardinalstone.com', 'Leave reclaim request');
		                       $message->to($userEmail)->subject('Leave Request Disapproval')->cc('hr@cardinalstone.com');
		                         });

		          if(count(Mail::failures()) > 0  )
		          {
		          		session()->flash('statusDanger', 'The request was not treated, because there was an error sending out the email. TRY AGAIN LATER');
		          		return false;
		          }

		          if( !(count(Mail::failures()) > 0)  )
		          {
		          	return true;
		          }


		    }


		    public function sendApprovalEmail($Emp_id, $request)
		    {
		    	$userEmail = Employee::find($Emp_id)->Emp_Email;
		                    Mail::send('pages.emails.approvalEmail', ['staffName' => $this->staff_name,
		                                                   'leaveType' => $this->leave_type,
		                                                   'startDate' => $this->start_date,
		                                                   'endDate'   => $this->end_date,
		                                                   'comments'  => $request->commentsByLineManager,
		                       ], function($message) use ($userEmail) {
		                           $message->from('leave@cardinalstone.com', 'Leave reclaim request');
		                         $message->to($userEmail)->subject('Leave Request Approval')->cc('hr@cardinalstone.com');
		                         });

		                     if(count(Mail::failures()) > 0  )
					          {		
					          		session()->flash('statusDanger', 'The request was not treated, because there was an error sending out the email. TRY AGAIN LATER');
					          		return false;
					          }

					          if( !(count(Mail::failures()) > 0)  )
					          {
					          	session()->flash('status', 'Request was successfully approved');
					          	return true;
					          }
		    }
}
