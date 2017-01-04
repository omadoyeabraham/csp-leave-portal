<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Http\Requests;
use Auth;
use DB;
use App\Employee;
use App\User;
use App\LeaveRequest;
use App\Http\helpers ;
use JavaScript;
use Redirect;

class clientPagesController extends Controller
{

      /**
       * Passes data to the leave summary view
       * @return array    of values used in the view.
       */
      public function showUserLeaveSummary( )
      {
          //$me = \App\Http\getLineManagersEmail('Elile Olutimayin');
          //dd($me);
          $user = User::find(Auth::user()->id);
          $userGender = session('global_user')->employee->Emp_Gender;

          //Getting no of days available to be taken for annual leave
          $carryOverDays = $user->COD_from_last_yr;
          $daysEarnedTillDate = Auth::user()->getDaysEarnedTillDate();
          $daysTaken = $user->no_of_leave_days_used;
          $daysAvailableForUse = $carryOverDays  + $daysEarnedTillDate - $daysTaken ;

          //Updating and saving the user with the new no of days available
          $user->no_of_leave_days_remaining = $daysAvailableForUse;
          $user->save();

          return view('pages.clientPages.summary', [
              'annualEligibledays'            => Auth::user()->getEligibleDays(),
              'daysEarnedTillDate'            => $daysEarnedTillDate ,
              'carryOverDays'                 => $user->COD_from_last_yr,
              'daysAvailableForUse'           => $user->no_of_leave_days_remaining,
              'daysTaken'                     => $user->no_of_leave_days_used,
              'sickLeaveDays'                 => $user->sick_leave,
              'compassionateLeaveDays'        => $user->compassionate_leave,
              'studyLeaveDays'                => $user->study_leave,
              'paternityMaternityLeaveDays'   => $user->paternity_maternity_leave,
              'userGender'                    => $userGender,
             
          ]);
      }

      /**
       * Shows the apply for leave view
       * array  of values used in the view
       */
      public function showApplyForLeave(User $user)
      {

          $holidays = \App\Http\getHolidays();
          //dd(  \App\Http\getAllLineManagers() );
          //Giving the maxNoOfDays/holidays to javascript for validation purposes
          JavaScript::put([
                'maxNoOfDays' => $user->no_of_leave_days_remaining,
                'holidays'    => $holidays
            ]);

          //Used to ensure (default) appears on the first LM in the array
          $lineManagersList = Auth::user()->getLineManagersList();
            $bioDataIsComplete = Auth::user()->bioDataIsComplete();
             $userIsConfirmed = Auth::user()->isConfirmed();

          //Getting all other line Managers
          $allLineManagers = \App\Http\getAllLineManagers();
          foreach ($allLineManagers as $lineManager) {
            array_push($lineManagersList, $lineManager);
          }

          //Making sure the array values are unique and that array keys are not missing
          $lineManagersList = array_values ( array_unique($lineManagersList) );
         
          $counter = count($lineManagersList);
          $intranetLink = "intranet.cardinalstone.com/intranet/index.php?module=profile&action=edit&user=".Auth::user()->username;

          return view('pages.clientPages.applyForLeave',[
              'leaveTypes'  =>  \App\Http\getLeaveTypes(),
              'lineManagersList'  => $lineManagersList,
              'counter'          =>  $counter,
               'bioDataIsComplete'    => $bioDataIsComplete,
               'intranetLink'     => $intranetLink,
               'userIsConfirmed'  =>  $userIsConfirmed,
          ]);
      }

      /**
       * Sends out the leave request
       */
      public function postLeaveRequest(Request $request, $id)
      {

          $user = User::find($id);

          $startDateTimeStamp = strtotime($_POST['startDate']);
          $endDateTimeStamp = strtotime($_POST['endDate']);
          $startDay = (int) ( Date('N',   $startDateTimeStamp ) );
          $endDay =   (int) ( Date('N',   $endDateTimeStamp ) );

          //dd($startDay);
          //dd( $_POST['noOfDays'] );

          if( $_POST['noOfDays'] === 'Invalid Date range' || $_POST['noOfDays'] === 'Exceeds max no of days ' || $_POST['noOfDays'] === " " || $_POST['noOfDays'] === "" )
          {
            session()->flash('statusDanger', "You cannot apply for leave with the date range specified");
              //return redirect('/applyForLeave/'. $id);
               return redirect()->back()->withInput();
          }

          if( ($startDay > 5) && ($startDay <= 7) )
          {

            //dd("Beginning with weekend");
            session()->flash('statusDanger', "You cannot start your leave on weekends");
            //session()->flash('status', "You cannot start your leave on weekends");
            //dd(session('statusDanger'));
            //return Redirect::back()->withInput();
            //dd('Here');
            //return redirect('/applyForLeave/'. $id);
            return redirect()->back()->withInput();
          }

          if( ($endDay > 5) && ($endDay <= 7) )
          {
            session()->flash('statusDanger', "You cannot end your leave on weekends");
           //return redirect('/applyForLeave/'. $id);
            return redirect()->back()->withInput();
          }


          $noOfDays =   explode(" ",$request->noOfDays)[0];


          if( !(is_numeric($noOfDays) ) )
          {
            session()->flash('statusDanger', "The daterange selected is invalid, ensure that the startdate occurs before the enddate, and 
              that you are not trying to apply for leave days that exceed your current allocation");
            //return redirect('/applyForLeave/'.Auth::user()->id);
            //return redirect('/applyForLeave/'. $id);
             return redirect()->back()->withInput();
          }
         // $me = \App\Http\getLineManagersEmail($request->lineManager);
          //dd($me);
         
          Auth::user()->sendLeaveRequest($request->leaveType, $request->startDate, $request->endDate, $noOfDays, $request->lineManager, $request->comments);

          if(Auth::user()->validRequest)
          {
              session()->flash('status', 'Your request has been successfully sent!');
              return redirect('/');
          }

          if( !(Auth::user()->validRequest) )
          {
              //session()->flash('statusDanger', "There was a challenge processing your request, please try again later");
              //return redirect('/applyForLeave/'. $id);
               return redirect()->back()->withInput();
          }

      }

      /**
       * [Shows all the leave Requests that a user has made]
       * @param  User   $user [description]
       * @return [type]       [description]
       */
      public function showUserRequestStatus(User $user)
      {
          $requests = $user->leaveRequests;
          return view('pages.clientPages.requestStatus', compact('requests'));
      }

      public function showReclaimDays()
      {
             //Used to ensure (default) appears on the first LM in the array
          $lineManagersList = Auth::user()->getLineManagersList();

          //Getting all other line Managers
          $allLineManagers = \App\Http\getAllLineManagers();
          foreach ($allLineManagers as $lineManager) {
            array_push($lineManagersList, $lineManager);
          }

          //Making sure the array values are unique and that array keys are not missing
          $lineManagersList = array_values ( array_unique($lineManagersList) );
         
          $counter = count($lineManagersList);
          
          return view('pages.clientPages.reclaimDays', [
                'lineManagersList'  => $lineManagersList,
                'counter'           =>  $counter
            ]);
      }

      /**
       * [Used to post a reclaim request]
       * @param  Request $request [description]
       * @param  User    $user    [description]
       * @return [type]           [description]
       */
      public function reclaimDays(Request $request,  User $user)
      {
          $lineManagersEmail = \App\Http\getLineManagersEmail($request->lineManager);
          $user->sendReclaimRequest($request->noOfDays, $request->lineManager, $request->reason, $lineManagersEmail);
          session()->flash('status', 'Your request has been sent successfully.');
          return redirect('/reclaimDays');
      }

      public function showLeavePolicy()
      {
          return view('pages.clientPages.leavePolicy');
      }







}//End of main Class
