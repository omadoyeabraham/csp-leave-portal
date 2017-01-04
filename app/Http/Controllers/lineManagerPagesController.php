<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\User;
use App\Employee;
use App\LeaveRequest;

class lineManagerPagesController extends Controller
{
		/**
		 * Shows all leaveRequests made to a LM
		 * @returns a view
		 */
	    public function showReplyLeaveRequests()
	    {
	    	if( !(Auth::user()->isLineManager() ) )
	    	{
	    		session()->flash('statusDanger', 'You are currently not allowed to visit the replyLeaveRequests page, because you are not a line manager.');
	    		return redirect('/');
	    	}

	    	$leaveRequests = Auth::user()->getPendingRequests();
	    	return view('pages.lineManagerPages.replyLeaveRequests' , compact('leaveRequests'));
	    }


	    public function respondToLeaveRequests(Request $request)
	    {

	    	if( !(Auth::user()->isLineManager() ) )
	    	{
	    		session()->flash('statusDanger', 'You are currently not allowed to respond to leave Requests because you are not a line manager.');
	    		return redirect('/');
	    	}

	   		//Approving request
	    	if( isset($request->approveLeaveRequest))
	    	{
	    		foreach ($request->leaveRequestcheckbox as $checkbox) {
	    			$leaveRequest = LeaveRequest::find($checkbox);
	    			if (! (\App\Http\validateRequestDays($leaveRequest->Emp_id, $leaveRequest->leave_type, $leaveRequest->no_of_days)))
	    			{
	    				session()->flash('statusDanger', 'This request cannot be approved, the applicant does not have sufficient leave days');
	    				return redirect('/replyLeaveRequests');
	    			}

	    			if(\App\Http\validateRequestDays($leaveRequest->Emp_id, $leaveRequest->leave_type, $leaveRequest->no_of_days) )
	    			{
	    				Auth::user()->modifyDB($leaveRequest,$request,$leaveRequest->Emp_id,$leaveRequest->leave_type, $leaveRequest->no_of_days, true );
	    				return redirect('/replyLeaveRequests');
	    			}
	    			
	    		}
	    		
	    	}

	    	//Disapproving request
	    	if( isset($request->disapproveLeaveRequest))
	    	{
	    		foreach ($request->leaveRequestcheckbox as $checkbox) {
	    			$leaveRequest = LeaveRequest::find($checkbox);
	    			Auth::user()->modifyDB($leaveRequest,$request,$leaveRequest->Emp_id,$leaveRequest->leave_type, $leaveRequest->no_of_days, false );

	    		}
	    		return redirect('/replyLeaveRequests');
	    	}
	    	
	    		
	    }
}
