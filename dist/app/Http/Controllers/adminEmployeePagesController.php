<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\User;
use Redirect;

class adminEmployeePagesController extends Controller
{

    /**
     * Getting a user's Leave summary
     */
    public function employeeLeaveSummary($id)
    {
        $employee = User::find($id);
        $userGender = $employee->load('employee')->employee->Emp_Gender;
       //dd($userGender);
        $annualEligibledays =  $employee->getEligibleDays();
        $daysEarnedTillDate = $employee->getDaysEarnedTillDate();


        return view('pages.adminPages.specificEmployee.employeeLeaveSummary',[
            'employee'  => $employee,
            'annualEligibledays'  => $annualEligibledays,
            'daysEarnedTillDate'  =>  $daysEarnedTillDate,
            'userGender'          =>  $userGender,
        ]);
    }

    /**
     * View Confirming a User
     */
    public function confirmEmployee($id)
    {
        $employee = User::find($id);
        return view('pages.adminPages.specificEmployee.confirmEmployee',compact('employee'));

    }

    /**
     * Processing user confirmation/unconfirmation
     */
    public function processEmployeeConfirmation($id)
    {
       $employee = User::find($id);
       if($_SERVER['REQUEST_METHOD'] === 'POST')
       {
         //Confirming the employee
         if(isset($_POST['confirmEmployee']))
         {
           $employee->confirmation_status = 1;
           $employee->save();
           session()->flash('status',$employee->name." has been successfully confirmed");
         }

         //Unconfirming the employee
         if(isset($_POST['unconfirmEmployee']))
         {
           $employee->confirmation_status = 0;
           $employee->save();
          session()->flash('status',$employee->name." has been successfully unconfirmed");
         }
       }

       return Redirect::back();
    }

    /**
     * Assign Line manager
     */
    public function assignLineManager($id)
    {
        $employee = User::find($id);
        $lineManagers = DB::table('dbo.BUSINESS_UNITS')->lists('line_manager_name');
        $partners = DB::table('dbo.BUSINESS_UNITS')->lists('unit_head');
        $allPossibleLineManagers = array_keys(array_flip(array_merge($lineManagers , $partners)));
        //dd($lineManagers);
        return view('pages.adminPages.specificEmployee.assignLineManager',[
              'employee' => $employee,
              'allPossibleLineManagers' => $allPossibleLineManagers
        ]);
    }

    /**
     * Assigning a line manager and overwriting the default LM
     */
    public function processAssignLineManager($id)
    {
        $employee = User::find($id);
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
          if(isset($_POST['assignLineManager']))
          {
            $employee->line_manager = htmlspecialchars($_POST['lineManager']);
            $employee->save();
            session()->flash('status', 'The line manager has been changed');
          }
        }

          return Redirect::back();
    }
}
