<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Auth;
use App\User;
use App\Employee;


class adminPagesController extends Controller
{
      //Route to the public holiday manager
      public function phm(){

        //Check to ensure only HR members can view this page
        if( !(Auth::user()->isAdmin() ) )
        {
            session()->flash('statusDanger', 'You currently do not have admin access, pls contact the IT Unit for enquiries.');
            return redirect('/');
        }
        
        $publicHolidays = DB::table('dbo.LEAVE_PUBLIC_HOLIDAYS')->select('id','holiday_name','holiday_date')->get();
        return view ('pages.adminPages.phm', compact('publicHolidays'));
       }

      //Route to the getReports page
      public function getReports(){
         //Check to ensure only HR members can view this page
              if( !(Auth::user()->isAdmin() ) )
              {
                  session()->flash('statusDanger', 'You currently do not have admin access, pls contact the IT Unit for enquiries.');
                  return redirect('/');
              }
        return view('pages.adminPages.getReports');
      }

      //Route to the add-sub page
      public function add_sub(){
        return view('pages.adminPages.add_sub');
      }

      /**
       * CRUD public holidays
       */
      public function processPublicHolidays()
      {
          /**
           * Creating a new holiday
           */
          if(isset($_POST['createHoliday']))
          {
            if (  DB::table('dbo.LEAVE_PUBLIC_HOLIDAYS')->insert([
                    'holiday_name' => $_POST['holidayName'],
                    'holiday_date' =>  $_POST['holidayDate']
              ]) )
              session()->flash('status', "The new Holiday has been created");
          }

          /**
           * Deleting a public holiday
           */

          if(isset($_POST['deleteHoliday']))
           {

               if(isset($_POST['publicHolidayCheckbox']))
               {
                    $rowIds = $_POST['publicHolidayCheckbox'];
                    foreach($rowIds as $rowId)
                    {

                      DB::table('dbo.LEAVE_PUBLIC_HOLIDAYS')->where('id','=',$rowId)
                                                      ->delete();
                    }

                   session()->flash('status', "The holiday has been deleted");

               }
           }

           /**
            * Editing a public holiday
            */
          if(isset($_POST['editHoliday']))
          {
              if(isset($_POST['publicHolidayCheckbox']))
              {
                   $rowIds = $_POST['publicHolidayCheckbox'];
                   foreach($rowIds as $rowId)
                   {
                     DB::table('dbo.LEAVE_PUBLIC_HOLIDAYS')->where('id',$rowId)
                                                     ->update([
                                                       'holiday_name' => $_POST['editHolidayName'],
                                                       'holiday_date' => $_POST['editHolidayDate']
                                                     ]);
                   }
                  session()->flash('status', "The holiday has been edited");
              }
          }
          return redirect('/phm');
      }

        /**
         * DATATABLES
         */
        public function dataTables()
        {
             //Check to ensure only HR members can view this page
              if( (Auth::user()->isAdmin() ) )
              {
                  session()->flash('statusDanger', 'You currently do not have admin access, pls contact the IT Unit for enquiries.');
                  return redirect('/');
              }

            //Getting the list of all users
            $allUsers = User::all();
            //dd($allUsers[3]);
            return view('pages.adminPages.dataTables',compact('allUsers'));
        }

        /**
         * Getting a particular user's details
         */
        public function adminGetUser($id)
        {
             //Check to ensure only HR members can view this page
              if( !(Auth::user()->isAdmin() ) )
              {
                  session()->flash('statusDanger', 'You currently do not have admin access, pls contact the IT Unit for enquiries.');
                  return redirect('/');
              }
          session()->put('adminEmployeeId', $id);
          return redirect(  url('/adminEmployeeLeaveSummary', array(session()->get('adminEmployeeId')))  );
        }

        /**
         * Used to automatically carry over leave days for none first years at the beginning of every year.
         * @return [type] [description]
         */
        public function carryOver()
        {
          /**
           * 1) Get all users
           * 2) Loop through all users
           * 3) For each user determine whether its user's first year or Not
           * 4) If its not, 
           * 				MOve remaining balance(max 5days) to COD days // ONLY FOR NON_PARTNERS
           *         Make all specific leaves and no_of_leave_days_used 0
           * 				recompute no of leave days remaining
           * 5) If it is
           *         Move all leave days remaining to COD 
           * 5) At the end of loop give success information
           */
          
               //Check to ensure only HR members can view this page
              if( !(Auth::user()->isAdmin() ) )
              {
                  session()->flash('statusDanger', 'You currently do not have admin access, pls contact the IT Unit for enquiries.');
                  return redirect('/');
              }
          
          $allUsers = User::all();
          foreach ($allUsers as $singleUser) 
          {

              //getting no of years user has been employed
              $employeeRel = $singleUser->load('employee')->employee;
              $startDate = $employeeRel->Emp_Start_Date;
              $date = date_parse($startDate);
              $employeeStartYear =  $date['year'];
              $employeeStartMonth = $date['month'];
              $employeeStartDay = $date['day'];

              $daysToBeCarriedOver = (int) $singleUser->no_of_leave_days_remaining;
              
              //If user is over a year old in the firm, limit COD to 5 maximum
              if( date('Y') - $employeeStartYear > 1 )
              {

                  if($daysToBeCarriedOver >= 5 && !$singleUser->isPartner() )
                  {
                      
                      $daysToBeCarriedOver = 5;
                  }
              }

              $singleUser->sick_leave = 0;
              $singleUser->study_leave = 0;
              $singleUser->compassionate_leave = 0;
              $singleUser->paternity_maternity_leave = 0;
              $singleUser->no_of_leave_days_used = 0;
              $singleUser->COD_from_last_yr = $daysToBeCarriedOver;
              $singleUser->save();

              DB::table('dbo.LEAVE_CARRYOVER')->where('staff',$employeeRel->Emp_Username)
                                                 ->update([
                                                   'no_of_days' => $daysToBeCarriedOver,
                                                 ]);

          }

          //Redirect with status
          session()->flash('status', 'Carryover operation was successful');
          return redirect('/carryOver');


         
        }

        public function viewCarryOver(){
             //Check to ensure only HR members can view this page
        if( !(Auth::user()->isAdmin() ) )
        {
            session()->flash('statusDanger', 'You currently do not have admin access, pls contact the IT Unit for enquiries.');
            return redirect('/');
        }
          return view('pages.adminPages.carryOver');
        }
}
