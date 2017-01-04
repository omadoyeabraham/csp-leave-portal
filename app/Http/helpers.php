<?php

namespace App\Http;

Use App\Employee;
use App\User;
Use DB;
Use Auth;


    function getAllLineManagers()
    {
         $lm = DB::table('dbo.BUSINESS_UNITS')->lists('line_manager_name');
         $lm2 = DB::table('dbo.employees')->where('Line_Manager', "Y")->select('Emp_Firstname','Emp_Lastname')->get();
         $lm3 = [];
         foreach ($lm2 as $lmSingle) {
           $name = $lmSingle->Emp_Firstname . " " . $lmSingle->Emp_Lastname;
           array_push($lm3, $name);
         }
        
          $lmFinal = array_merge($lm, $lm3);
         $lmUnique = array_unique($lmFinal);
         $lmUnique = array_diff($lmUnique, array('HR Manager') );

         asort($lmUnique);
         //dd($lmUnique);
         return $lmUnique;
    }

      /**
       * Get an array of all partners
       * @return Array    $partnersList
       */
     function getPartnersList()
      {
          $partners = Employee::where('Emp_level' , '=', 4)->get();
          $partnersList = [];

          foreach ($partners as $partner) {
              $partnerName = $partner->Emp_Firstname ." ". $partner->Emp_Lastname;
              array_push($partnersList, $partnerName);
          }

          return $partnersList;

      }//EOF fn getPartnersList



      /**
       * Get an array of all the leave types
       * @return Array     $leaveTypes
       */
      function getLeaveTypes()
      {
          $leaveTypes = [];
          $leaves = DB::table('dbo.LEAVE_TYPE')->lists('leave_type');
          $userGender = Employee::find(Auth::user()->Emp_id)->Emp_Gender;
          
          foreach ($leaves as $leaveType )
           {
              array_push($leaveTypes, $leaveType);
           }

           if($userGender == "M")
           {
              $leaveTypes = array_diff($leaveTypes , array("Maternity"));
           }

           if($userGender == "F")
           {
              $leaveTypes = array_diff($leaveTypes , array("Paternity"));
           }

           return $leaveTypes;
      }

      /**
       * Get an array of all staff with levels higher than the user
       * @return Array  $higherStaffArray
       */
      function getHigherStaff()
      {
          $higherStaffArray = [];
          $employeeLevel =  session('global_user')->employee->Emp_Level;
          $higherStaffs = Employee::where('Emp_Level', '>', (int)$employeeLevel)
                                        ->select('Emp_Firstname', 'Emp_Lastname')
                                        ->get();
          foreach ($higherStaffs as $higherStaff)
          {
              $higherStaffName = $higherStaff->Emp_Firstname ." ". $higherStaff->Emp_Lastname;
              array_push($higherStaffArray, $higherStaffName);
          }
          return $higherStaffArray;
      }

      /**
       * Get a list of all public holidays for the year
       * @return [type] [description]
       */
       function getHolidays()
      {
          $holidaysQuery = DB::table('dbo.LEAVE_PUBLIC_HOLIDAYS')->lists('holiday_date');
          $holidays = [];
          foreach ($holidaysQuery as $holiday) {
            array_push($holidays, $holiday);
          }

          return $holidays;
      }

      /**
       * Get an email for a line manager
       * @param  [type] $lineManagerName [description]
       * @return [type]                  [description]
       */
      function getLineManagersEmail ($lineManagerName)

      {
              //When someone applies to the HR Manager
             if($lineManagerName === 'Adekunle Obadina')
             {
                //$HrEmail = DB::table('dbo.BUSINESS_UNITS')->where('unit_id', 10)->first()->line_manager_email;
                //return $HrEmail;
                return 'kunle.obadina@cardinalstone.com';
             }

            $LM_Emp_Id = (int) DB::table('dbo.LEAVE_USERS')->where("name", '=', "$lineManagerName")->first()->Emp_id;
            $LM = Employee::find($LM_Emp_Id);
            return $LM->Emp_Email;

            /*$line_manager_email = explode(" ",$lineManagerName);
            $line_manager_email_for_this_request = $line_manager_email[0] ."." .$line_manager_email[1]."@cardinalstone.com";
            return $line_manager_email_for_this_request;
            */
      }

      function validateRequestDays($Emp_id, $leaveType, $noOfDays)
      {
          $user = Employee::find($Emp_id)->load('user');
          $user = $user->user;
          
          switch ($leaveType) {

            case 'Annual':
                  if( ($noOfDays) > $user->no_of_leave_days_remaining  )
                  {
                      
                      return false;
                  }
                  return true;
              break;

              case 'Sick':
                  if( ($noOfDays + $user->sick_leave) > 5  )
                  {
                      return false;
                  }
                  return true;
              break;

              case 'Compassionate':
                  if( ($noOfDays + $user->compassionate_leave) > 3  )
                  {
                      return false;
                  }
                  return true;
              break;

              case 'Study/Exam':
                  if( ($noOfDays + $user->study_leave) > 5  )
                  {
                      return false;
                  }
                  return true;
              break;

              case 'Paternity':
                  if( ($noOfDays + $user->paternity_maternity_leave) > 5  )
                  {
                      return false;
                  }
                  return true;
              break;

              case 'Maternity':
                  if( ($noOfDays + $user->paternity_maternity_leave) > 90  )
                  {
                      return false;
                  }
                  return true;
              break;

              case 'Reclaim Request':
                  if( ($noOfDays > $user->no_of_leave_days_used)  )
                  {   
                      session()->flash('statusDanger', 'User cannot reclaimed more days than previously used');
              
                      return false;
                  }
                  return true;
              break;


            
            default:
              # code...
              break;
          }
      
      }





 ?>
