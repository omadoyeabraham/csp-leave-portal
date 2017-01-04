<?php

namespace App\Http\Controllers\Auth;


use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use App\User;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Employee;

class AuthController extends Controller
{
    protected $username = 'username';
    protected $guard = 'web';
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Return the authenticated response.
     *
     * @param  $request
     * @param  $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    protected function authenticated(Request $request, $user)
    {
        
        //dd($user);
        //Updating the users Emp_Id with the one from dbo.EMPLOYEES
        $employee = Employee::where('Emp_Username', Auth::user()->username)->first();

        DB::table('LEAVE_USERS')->where('username','=',Auth::User()->username)
                              ->update([
                                    'Emp_Id' => $employee->Emp_Id,

                                  ]);

        $me =  collect( DB::table('LEAVE_USERS')->where('username','=',Auth::User()->username)->get()[0] )->first();
        $user = User::find($me);

        
        $globalUser = $user->load('employee');
        
        session()->put('global_user', $globalUser);
        //Populating needed session variables
        $request->session()->put('user_id', $user->id);
        $request->session()->put('emp_id', $user->Emp_id);
        $request->session()->put('username', $user->username);
        $request->session()->put('user_email', $user->email);


          return redirect()->intended($this->redirectPath());

    }
}
