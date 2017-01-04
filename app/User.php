<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Adldap\Laravel\Traits\AdldapUserModelTrait;
use App\Employee;
use App\User;
use App\LeaveRequest;
use App\functions\functions;
use Auth;
use DB;
use Mail;
use Redirect;

class User extends Authenticatable
{
  use AdldapUserModelTrait;

    /**
     * Name of the table that is bound to the User Model.
     * @var string
     */
     protected $table = 'dbo.LEAVE_USERS';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password', 'Emp_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * CLASS PROPERTIES
     */
    protected $lineManagersList = [];
    protected $partnersList = [];
    protected $annualEligibledays;
    protected $daysEarnedTillDate;
    protected $remainingPartners = [];
    protected $userLineManager;
    protected $userUnitHead;
    public $validRequest = false;


    /**
     * Checks if the user database
     * @return [type] [description]
     */
    public function bioDataIsComplete()
    {
        $employee = $this->employee;
        if(is_null($employee->Emp_NOK_Fullname) || is_null($employee->Emp_NOK_Rel) || is_null($employee->Emp_NOK_Mobile) || is_null($employee->Emp_NOK_Address) 
              || is_null($employee->Emp_Home_Address_1) || is_null($employee->Emp_Home_Address_2)
          )
        {
            return false;
        }

        return true;
        
    }

    public function isConfirmed()
    {
        $employee = $this->employee;
        if($employee->Emp_Confirmed != "1")
        {
            return false;
        }

        return true;
    }

    public function getGlobalUser()
    {
        if ( session()->has('global_user'))
        {
           return session('global_user');
        }


       // dd($globalUser);
    }

    /**
     * Employee relationship with the user
     * @return An instance of employee
     */
    public function employee()
    {
        return $this->hasOne(Employee::class, 'Emp_Id', 'Emp_id');
    }

    /**
     * User relationship with the leaveRequests
     * @return all leaverequests belonging to a user
     */
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'Emp_Id', 'Emp_id');
    }

    /**
     * LineManagers relationship with leaveRequests
     * @return all leaverequests made to a lineManager (if user is a LM)
     *         else it returns null
     */
    public function lineManagerLeaveRequests()
    {
        if( ($this->isLineManager() ) )
        {

           return $this->hasMany(LeaveRequest::class, 'line_manager', 'name');

        }
          return null;
    }

    public function getPendingRequests()
    {
           $requests = $this->lineManagerLeaveRequests;
           $pendingRequests = [];
           foreach ($requests as $request) {
              if($request->application_status === "pending")
              {
                  array_push($pendingRequests, $request);
              }

           }
           return $pendingRequests;
    }


    /**
     *Determine if the user is a partner
     *@return    boolean
     */
      public function isPartner()
      {
          $user = $this::with('employee')->find( Auth::user()->id);

          if ($user->Emp_id === 4)
          {
              return true;
          }

          return false;
      }


      /**
       *Determine if the user is a partner
       *@param     User     $user
       *@return    boolean
       */
        public function isLineManager()
        {
            $user = Auth::user()->load('employee');

            if ($user->employee->Line_Manager === "Y")
            {
                return true;
            }

            return false;

        }

        /**
         * Used to determine if the user is an admin user i.e HR
         * @return boolean [description]
         */
        public function isAdmin()
        {
            $user = Auth::user()->load('employee');


            if ( (int)$user->employee->Emp_Business_Unit === 10)
            {

                return true;
            }

            return false;
        }

        /**
         * Returns the lineManager for a user
         * @return [type] [description]
         */
        public function getLineManager()
        {
            $employeeUnitHeadQuery = DB::select('SELECT unit_head,line_manager_name
                                                      FROM dbo.BUSINESS_UNITS
                                                      WHERE unit_id=?',[Auth::user()->load('employee')->employee->Emp_Business_Unit ])[0];

            $this->userLineManager = $employeeUnitHeadQuery->line_manager_name;
            return $this->userLineManager;
        }
        /**
         * Get user's unit head
         * @return string   userUnitHead
         */
        public function getUnitHead()
        {

            $employeeUnitHeadQuery = DB::select('SELECT unit_head,line_manager_name
                                                      FROM dbo.BUSINESS_UNITS
                                                      WHERE unit_id=?',[Auth::user()->load('employee')->employee->Emp_Business_Unit ])[0];

            $this->userUnitHead = $employeeUnitHeadQuery->unit_head;
            return $this->userUnitHead;
        }

        public function getRemainingPartners()
        {
            $partners = \App\Http\getPartnersList();

            if( $this->isPartner() )
            {
                $remainingPartners = array_diff($partners,array($this->name));
            }

            if( !( $this->isPartner() ) )
            {
                $this->userUnitHead = $this->getUnitHead();
                $remainingPartners = array_diff($partners, array(  $this->userUnitHead ) );
            }

            return $remainingPartners;
        }

      

      /**
       * Populating the users linemanager array
       * @param    User      $user
       * @return   string   $this->line_manager
       */
      public function getLineManagersList()
      {

          if( ( $this->isPartner()  ) )
          {
              $this->userLineManager = null;
              $this->userUnitHead = null;
              $remainingPartners = $this->getRemainingPartners();
              array_push($this->lineManagersList, $remainingPartners);

              return $this->lineManagersList;
          }

          if( ($this->isLineManager() ) )
          {
                $this->userLineManager = null;
                $this->userUnitHead = $this->getUnitHead();

                $remainingPartners = $this->getRemainingPartners();

                array_push($this->lineManagersList, $this->userUnitHead);
                foreach ($remainingPartners as $remainingPartner) {
                      array_push($this->lineManagersList, $remainingPartner);
                }


          }

          //user is not a partner and not a LM
          if( !($this->isPartner()) && !($this->isLineManager()) )
          {
              $this->userLineManager = $this->getLineManager();
              $this->userUnitHead = $this->getUnitHead();

             $remainingPartners = $this->getRemainingPartners();
             //$remainingLM = $this->getRemainingLM();

              array_push($this->lineManagersList, $this->userLineManager, $this->userUnitHead);
              foreach ($remainingPartners as $remainingPartner) {
                    array_push($this->lineManagersList, $remainingPartner);
              }
          }

          if($this->line_manager !== "default")
          {
               $this->lineManagersList = array_diff($this->lineManagersList,array($this->line_manager));
               array_unshift($this->lineManagersList, $this->line_manager ) ;
          }



          return $this->lineManagersList;
      }

      /**
       * Getting the max no of annual leave days a user is entitled to in a year.
       * @return   int      $eligibleDays
       */
      public function getEligibleDays()
      {
            $employeeLevel =  Auth::user()->load('employee')->employee->Emp_Level;

          switch ($employeeLevel)
          {
                case 0:
                    $this->annualEligibledays = 10;
                  break;
                case 1:
                    $this->annualEligibledays = 15;
                  break;
                case 2:
                    $this->annualEligibledays = 20;
                  break;
                case 3:
                    $this->annualEligibledays = 25;
                  break;
                case 4:
                    $this->annualEligibledays = 30;
                  break;

                default:
                    $this->annualEligibledays = 0;
                  break;

          }

          return $this->annualEligibledays;

      }


      /**
       * Determining the no of Annual leave days the user has earned this yr.
       * int    $daysEarnedThusFar
       */
      public function getDaysEarnedTillDate()
      {
          //  $eagerLoadedUser = Auth::user()->load('employee');
            //dd($eagerLoadedUser);
            $employeeStartDate = session('global_user')->employee->Emp_Start_Date;
            $date = date_parse($employeeStartDate);
            $employeeStartYear      =  $date['year'];
            $employeeStartMonth     = $date['month'];
            $employeeStartDay       = $date['day'];

            $daysEarnedPerMonth = $this->getEligibleDays()/ 12;
            $year = (int)date("Y");
            $month = (int)date("n");

            //Employee is a first year hire
            if($employeeStartYear === $year )
            {
              $x = $employeeStartMonth - 1;
              $this->daysEarnedTillDate =  ceil($daysEarnedPerMonth * ($month -1  - $x) );
            }

            //Older than one year aleady at the firm
            if($employeeStartYear < $year)
            {
              $this->daysEarnedTillDate = ceil($daysEarnedPerMonth * ($month - 1) );
            }

            //dd($this->daysEarnedTillDate);
          return $this->daysEarnedTillDate;
      }

      //Getting days earned till date for user that is not the authenticated user
      public function externalGetDaysEarnedTillDate($id)
      {
          $user = User::find($id);
          $employeeStartDate = $user->load('employee')->employee->Emp_Start_Date;
          //dd($employeeStartDate);
          $date = date_parse($employeeStartDate);
          $employeeStartYear      =  $date['year'];
          $employeeStartMonth     = $date['month'];
          $employeeStartDay       = $date['day'];
          //dd($employeeStartDay);
          $daysEarnedPerMonth = $user->externalGetEligibleDays($id)/ 12;
          //dd($daysEarnedPerMonth);
          $year = (int)date("Y");
          $month = (int)date("n");
          $daysEarnedTillDate;
          //Employee is a first year hire
          if($employeeStartYear === $year )
          {
            $x = $employeeStartMonth - 1;
              $daysEarnedTillDate =  ceil($daysEarnedPerMonth * ($month -1 - $x) );
          }

          //Older than one year aleady at the firm
          if($employeeStartYear < $year)
          {
              $daysEarnedTillDate = ceil($daysEarnedPerMonth * ($month-1) );
          }


        return   $daysEarnedTillDate;
      }

      public function externalGetEligibleDays($id)
      {
          $user = User::find($id);
          $employeeLevel = $user->load('employee')->employee->Emp_Level;
          switch ($employeeLevel)
          {
                case 0:
                    $annualEligibledays = 10;
                  break;
                case 1:
                      $annualEligibledays = 15;
                  break;
                case 2:
                    $annualEligibledays = 20;
                  break;
                case 3:
                    $annualEligibledays = 25;
                  break;
                case 4:
                      $annualEligibledays = 30;
                  break;

                default:
                    $annualEligibledays = 0;
                  break;

          }

          return   $annualEligibledays;

      }

      /**
       * [Used to send an email to the LM after a new leave request is created]
       * @return [type] [description]
       */
      public function sendRequestEmail($noOfDays, $start_date, $end_date, $comments, $lineManager, $lineManagersEmail  )
      {
          //dd($lineManagers)
          Mail::send('pages.emails.leaveRequest', ['noOfDays' => $noOfDays,
                                                   'start_date' => $start_date,
                                                   'end_date' => $end_date,
                                                   'commentsByStaff' => $comments,
                                                   'line_manager_for_this_request' => $lineManager
                       ], function($message) use ($lineManagersEmail) {
                           $message->from('leave@cardinalstone.com', 'Leave Request');
                          $message->to($lineManagersEmail)->subject('New Leave Request')->cc('hr@cardinalstone.com');
                         });
                         //$message->to($lineManagersEmail)->subject('New Leave Request')->cc('hr@cardinalstone.com');
                         session()->flash('status', 'Your request has been sent successfully');
                         return Redirect::back();
      }

      /**
       * [sendReclaimEmail description]
       * @param  [type] $noOfDays          [description]
       * @param  [type] $start_date        [description]
       * @param  [type] $end_date          [description]
       * @param  [type] $comments          [description]
       * @param  [type] $lineManager       [description]
       * @param  [type] $lineManagersEmail [description]
       * @return [type]                    [description]
       */
      public function sendReclaimEmail($noOfDays, $lineManager, $lineManagersEmail, $reason)
      {

          Mail::send('pages.emails.reclaimRequest', ['noOfDays' => $noOfDays,
                                                   'commentsByStaff' => $reason,
                                                   'line_manager_for_this_request' => $lineManager
                       ], function($message) use ($lineManagersEmail) {
                           $message->from('leave@cardinalstone.com', 'Leave reclaim request');
                        $message->to($lineManagersEmail)->subject('New Leave Reclaim Request')->cc('hr@cardinalstone.com');
                         });

                         session()->flash('status', 'Your request has been sent successfully');
                        return Redirect::back();
      }



      /**
       * [saveLeaveRequest description]
       * @param  [type]  $Emp_id              [description]
       * @param  [type]  $staff_name          [description]
       * @param  [type]  $line_manager        [description]
       * @param  [type]  $start_date          [description]
       * @param  [type]  $end_date            [description]
       * @param  [type]  $no_of_days          [description]
       * @param  [type]  $leave_type          [description]
       * @param  [type]  $date_applied        [description]
       * @param  [type]  $comments_by_staff   [description]
       * @param  [type]  $application_status  [description]
       * @param  [type]  $COD_from_last_yr    [description]
       * @param  boolean $days_gained_this_yr [description]
       * @return [type]                       [description]
       */
      public function saveLeaveRequest($Emp_id, $staff_name, $line_manager, $start_date, $end_date,
                                      $no_of_days, $leave_type, $date_applied, $comments_by_staff,
                                      $application_status, $COD_from_last_yr, $days_gained_this_yr, $lineManagersEmail)
      {
            $newLeaveRequest = new LeaveRequest;
            $newLeaveRequest->Emp_id            = $Emp_id;
            $newLeaveRequest->staff_name        = $staff_name;
            $newLeaveRequest->line_manager      = $line_manager;
            $newLeaveRequest->start_date        = $start_date;
            $newLeaveRequest->end_date          = $end_date;
            $newLeaveRequest->no_of_days        = $no_of_days;
            $newLeaveRequest->leave_type        = $leave_type;
            $newLeaveRequest->date_applied      = $date_applied;
            $newLeaveRequest->comments_by_staff = $comments_by_staff;
            $newLeaveRequest->application_status = $application_status;
            $newLeaveRequest->COD_from_last_yr   = $COD_from_last_yr;
            $newLeaveRequest->days_gained_this_yr = $days_gained_this_yr;

            $newLeaveRequest->save();

            //Only use this email function for regular leave requests
            if($leave_type !== "Reclaim Request")
            {
                $this->sendRequestEmail($no_of_days, $start_date, $end_date, $comments_by_staff, $line_manager, $lineManagersEmail );
            }

            if($leave_type === "Reclaim Request")
            {
                $this->sendReclaimEmail($no_of_days, $line_manager, $lineManagersEmail, $comments_by_staff);
            }

      }

      /**
       * used to actually send a leave application
       * @param  [type] $leaveType   [description]
       * @param  [type] $startDate   [description]
       * @param  [type] $endDate     [description]
       * @param  [type] $lineManager [description]
       * @param  [type] $comments    [description]
       * @return [type]              [description]
       */
      public function sendLeaveRequest($leaveType, $startDate, $endDate, $noOfDays, $lineManager, $comments="No comment given")
      {
          switch ($leaveType) {

            case 'Annual':

                  if (is_nan($noOfDays))
                  {
                      session()->flash('statusDanger', "You cannot apply for leave with an invalid date range");
                      $this->validRequest = false;
                      //dd(session('statusDanger'));
                      return Redirect::back()->withInput();
                  }

                  if($noOfDays > Auth::user()->no_of_leave_days_remaining)
                  {
                      session()->flash('statusDanger', "You can only apply for a maximum of ". Auth::user()->no_of_leave_days_remaining ." annual leave day(s)");
                      $this->validRequest = false;
                      return Redirect::back()->withInput();
                  }

                  $lineManagersEmail = \App\Http\getLineManagersEmail( $lineManager );


                  $this->saveLeaveRequest (Auth::user()->Emp_id,  Auth::user()->name,  $lineManager,  $startDate,  $endDate,
                                           $noOfDays,  $leaveType,  date("d-M-Y"),  $comments,  'pending',
                                            Auth::user()->COD_from_last_yr, $this->getDaysEarnedTillDate(), $lineManagersEmail
                                           );



              break; //Break annual leave

            case 'Sick':

                if (is_nan($noOfDays))
                {
                    session()->flash('statusDanger', "You cannot apply for leave with an invalid date range");
                    $this->validRequest = false;
                    return Redirect::back()->withInput();
                }

               if($noOfDays > (3 - Auth::user()->sick_leave) )
                {
                    session()->flash('statusDanger', "You can only apply for a maximum of ". ( - Auth::user()->sick_leave) ." sick leave day(s)");
                    $this->validRequest = false;
                    return Redirect::back()->withInput();
                }

                $lineManagersEmail = \App\Http\getLineManagersEmail( $lineManager );


                  $this->saveLeaveRequest (Auth::user()->Emp_id,  Auth::user()->name,  $lineManager,  $startDate,  $endDate,
                                           $noOfDays,  $leaveType,  date("d-M-Y"),  $comments,  'pending',
                                            Auth::user()->COD_from_last_yr, $this->getDaysEarnedTillDate(), $lineManagersEmail
                                           );


              break;

            case 'Compassionate':

                  if (is_nan($noOfDays))
                  {
                      session()->flash('statusDanger', "You cannot apply for leave with an invalid date range");
                      $this->validRequest = false;
                      return Redirect::back()->withInput();
                  }

               if($noOfDays > (3 - Auth::user()->compassionate_leave) )
                {
                    session()->flash('statusDanger', "You can only apply for a maximum of ". (3 - Auth::user()->compassionate_leave) ." compassionate leave day(s)");
                    $this->validRequest = false;
                    return Redirect::back()->withInput();
                }

                $lineManagersEmail = \App\Http\getLineManagersEmail( $lineManager );


                  $this->saveLeaveRequest (Auth::user()->Emp_id,  Auth::user()->name,  $lineManager,  $startDate,  $endDate,
                                           $noOfDays,  $leaveType,  date("d-M-Y"),  $comments,  'pending',
                                            Auth::user()->COD_from_last_yr, $this->getDaysEarnedTillDate(), $lineManagersEmail
                                           );
              break;

            case 'Study/Exam':

                if (is_nan($noOfDays))
                {
                    session()->flash('statusDanger', "You cannot apply for leave with an invalid date range");
                    $this->validRequest = false;
                    return Redirect::back()->withInput();
                }

               if($noOfDays > (5 - Auth::user()->study_leave) )
                {
                    session()->flash('statusDanger', "You can only apply for a maximum of ". (5 - Auth::user()->study_leave) ." study leave day(s)");
                    return Redirect::back()->withInput();
                }

                $lineManagersEmail = \App\Http\getLineManagersEmail( $lineManager );


                  $this->saveLeaveRequest (Auth::user()->Emp_id,  Auth::user()->name,  $lineManager,  $startDate,  $endDate,
                                           $noOfDays,  $leaveType,  date("d-M-Y"),  $comments,  'pending',
                                            Auth::user()->COD_from_last_yr, $this->getDaysEarnedTillDate(), $lineManagersEmail
                                           );
              break;

            case 'Maternity':

                   if (is_nan($noOfDays))
                    {
                        session()->flash('statusDanger', "You cannot apply for leave with an invalid date range");
                        $this->validRequest = false;
                        return Redirect::back()->withInput();
                    }

               if($noOfDays > (90 - Auth::user()->paternity_maternity_leave) )
                {
                    session()->flash('statusDanger', "You can only apply for a maximum of ". (90 - Auth::user()->paternity_maternity_leave) ." maternity leave day(s)");
                    $this->validRequest = false;
                    return Redirect::back()->withInput();
                }

                $lineManagersEmail = \App\Http\getLineManagersEmail( $lineManager );


                  $this->saveLeaveRequest (Auth::user()->Emp_id,  Auth::user()->name,  $lineManager,  $startDate,  $endDate,
                                           $noOfDays,  $leaveType,  date("d-M-Y"),  $comments,  'pending',
                                            Auth::user()->COD_from_last_yr, $this->getDaysEarnedTillDate(), $lineManagersEmail
                                           );
              break;

            case 'Paternity':

                  if (is_nan($noOfDays))
                    {
                        session()->flash('statusDanger', "You cannot apply for leave with an invalid date range");
                        $this->validRequest = false;
                        return Redirect::back()->withInput();
                    }

               if($noOfDays > (5 - Auth::user()->paternity_maternity_leave) )
                {
                    session()->flash('statusDanger', "You can only apply for a maximum of ". (5 - Auth::user()->paternity_maternity_leave) ." Paternity leave day(s)");
                    $this->validRequest = false;
                    return Redirect::back()->withInput();
                }

                $lineManagersEmail = \App\Http\getLineManagersEmail( $lineManager );


                  $this->saveLeaveRequest (Auth::user()->Emp_id,  Auth::user()->name,  $lineManager,  $startDate,  $endDate,
                                           $noOfDays,  $leaveType,  date("d-M-Y"),  $comments,  'pending',
                                            Auth::user()->COD_from_last_yr, $this->getDaysEarnedTillDate(), $lineManagersEmail
                                           );
              break;

            default:
                session()->flash('statusDanger', "Please select a valid leaveType");
                return Redirect::back();
              break;
          }
      }


      public function sendReclaimRequest($noOfDays, $lineManager, $reason, $lineManagersEmail)
      {
          if( is_nan($noOfDays) )
          {
              session()->flash('statusDanger', 'You must input a numeric number of days');
              return redirect('/reclaimDays')->withInput;
          }

          if( !(is_nan($noOfDays)) )
          {
              $this->saveLeaveRequest (Auth::user()->Emp_id,  Auth::user()->name,  $lineManager,  "N/A",  "N/A",
                                           $noOfDays,  "Reclaim Request",  date("d-M-Y"),  $reason,  'pending',
                                            Auth::user()->COD_from_last_yr, $this->getDaysEarnedTillDate(), $lineManagersEmail
                                           );
          }
      }

      public function modifyDB($leaveRequest,$request, $Emp_id,$leaveType, $noOfDays,$modType)
      {
          //Extra check to ensure none LM's can't approve leave requests
         if( !($this->isLineManager() ) )
          {
              session()->flash('statusDanger', 'You cannot approve this request, because you currently are not a line manager');
              return redirect('/replyLeaveRequests');
          }

          //Only LM's can approve/disaprrove
          if( ($this->isLineManager() ) )
          {
              //If its a disapproval
              if( !($modType) )
              {
                  //If disapproval email was sent successfully
                  if( $leaveRequest->sendDisapprovalEmail($Emp_id, $request) )
                  {
                    $leaveRequest->application_status = "disapproved";
                    $leaveRequest ->save();
                    session()->flash('status', 'Request has been successfully disapproved');
                    return redirect('/replyLeaveRequests');
                  }

                   //If disapproval email was not sent successfully
                  if( !($leaveRequest->sendDisapprovalEmail( $Emp_id, $request) ) )
                  {
                     session()->flash('status', 'There was a challenge sending out an email to disapprove this request, please try again later');
                     return redirect('/replyLeaveRequests');
                  }


              }

              //If approving the request
              if( $modType)
              {
                  //Couldn't send mail
                  if(! ($leaveRequest->sendApprovalEmail($Emp_id, $request)) )
                  {
                      session()->flash('status', 'There was a challenge sending out an email to approve this request, please try again later');
                      return redirect('/replyLeaveRequests');
                  }

                  //Sent the mail
                  if($leaveRequest->sendApprovalEmail($Emp_id, $request) )
                  {

                      $user = Employee::find($Emp_id)->load('user')->user;
                      switch ($leaveType) {
                           case 'Annual':

                                $user->no_of_leave_days_used = $user->no_of_leave_days_used + $noOfDays;
                                $user->no_of_leave_days_remaining = $user->no_of_leave_days_remaining - $noOfDays;
                                $user->save();
                                $leaveRequest->application_status = "approved";
                                $leaveRequest->save();
                             break;

                          case 'Reclaim Request':

                                $user->no_of_leave_days_used = $user->no_of_leave_days_used - $noOfDays;
                                $user->no_of_leave_days_remaining = $user->no_of_leave_days_remaining + $noOfDays;
                                $user->save();

                                $leaveRequest->application_status = "approved";
                                $leaveRequest->save();
                              break;

                             case 'Sick':

                                $user->sick_leave = $user->sick_leave + $noOfDays;
                                $user->save();

                                $leaveRequest->application_status = "approved";
                                $leaveRequest->save();
                             break;

                              case 'Compassionate':

                          $user->compassionate_leave = $user->compassionate_leave + $noOfDays;
                          $user->save();

                          $leaveRequest->application_status = "approved";
                          $leaveRequest->save();
                       break;

                       case 'Study/Exam':

                          $user->study_leave = $user->study_leave + $noOfDays;
                          $user->save();

                          $leaveRequest->application_status = "approved";
                          $leaveRequest->save();
                       break;

                       case 'Paternity':

                          $user->paternity_maternity_leave = $user->paternity_maternity_leave + $noOfDays;
                          $user->save();

                          $leaveRequest->application_status = "approved";
                          $leaveRequest->save();
                       break;

                         case 'Maternity':

                          $user->paternity_maternity_leave = $user->paternity_maternity_leave + $noOfDays;
                          $user->save();

                          $leaveRequest->application_status = "approved";
                          $leaveRequest->save();
                       break;

                     default:
                          Session()->flash('statusDanger', 'Error occured while trying to approve an invalid leaveType');
                          return redirect('/');
                       break;
                   }






                      return redirect('/replyLeaveRequests');
                  }
              }


          }
      }
























}
