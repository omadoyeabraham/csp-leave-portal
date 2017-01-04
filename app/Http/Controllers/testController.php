<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\User;
use App\Employee;

class testController extends Controller
{
    /**
     * SCRIPT run before the app goes live. It's used to update the app with correct COD and other leave details
     * @return [type] [description]
     */
    public function preLiveScript()
    {
        //Loop through DB
        //Foreach User in DB update record into dbo.Leave_Users
        $userDetails = DB::table("leave$")->get();

        foreach ($userDetails as $userDetail) 
        {
            //Getting the username from employees DB
            $employee = DB::table('dbo.EMPLOYEES')->where('Emp_Id', $userDetail->Emp_Id)->get();
            //dd($employee[0]->Emp_Username);
            
            $user = new User;
            $user->Emp_id = (int) $employee[0]->Emp_Id;
            $user->name = $userDetail->Username;
            $user->no_of_leave_days_used = $userDetail->Annual_Leave;
            $user->COD_from_last_yr = $userDetail->COD_from_last_yr;
            $user->sick_leave = $userDetail->Sick_Leave;
            $user->study_leave = $userDetail->Study_Leave;
            $user->compassionate_leave = $userDetail->Compassionate_Leave;
            $user->paternity_maternity_leave = $userDetail->Paternity_Maternity;
            $user->username = $employee[0]->Emp_Username;
            $user->save();

        }
    }

    public function test()
    {
        //dd ( Employee::all() );
        // 
        foreach ( User::all() as $user) 
        {
            if(is_null(Employee::find($user->Emp_id)))
            {
                dd($user);
            }
            $email = Employee::find( $user->Emp_id)->Emp_Email;

            $d = str_replace("@cardinalstone.com", "", $email);

            $user->username = $d;
            $user->save();
            echo $d . "<br>";
        }

        echo "<br><hr><hr><br>";

        foreach ( Employee::all() as $employee) 
        {
            $email = $employee->Emp_Email;

            $d = str_replace("@cardinalstone.com", "", $email);

            $employee->Emp_Username = $d;
            $employee->timestamps = false;
            $employee->save();
            
            echo $d . "<br>";
        }
    }
}
