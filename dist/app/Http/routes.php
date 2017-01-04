<?php


Route::get('/runPreLiveScript', 'testController@preLiveScript');
Route::get('/zxcvb', 'testController@test');

  //Route group to ensure that users are authenticated.
    Route::group(['middleware' => ['auth']], function(){

          /**
           * Routes for clients
           */
           Route::get('/',                        'clientPagesController@showUserLeaveSummary');
           Route::get('/summary',                  'clientPagesController@showUserLeaveSummary');
           Route::get('/applyForLeave/{user}' ,   'clientPagesController@showApplyForLeave');
           Route::post('/applyForLeave/postLeaveRequest/{id}',    'clientPagesController@postLeaveRequest');
           Route::get('/requestStatus/{user}',    'clientPagesController@showUserRequestStatus');
           Route::get('/reclaimDays',                               'clientPagesController@showReclaimDays');
           Route::post('/reclaimLeaveDays/{user}',                               'clientPagesController@reclaimDays');
           Route::get('/leavePolicy',                             'clientPagesController@showLeavePolicy');


           /**
            * Routes for LineManagers
            */
           Route::get('/replyLeaveRequests'     , "lineManagerPagesController@showreplyLeaveRequests");
           Route::post('/processLeaveRequests',    'lineManagerPagesController@respondToLeaveRequests');

           /**
            * Routes for admin
            */
           Route::get('/phm', 'adminPagesController@phm');
         		Route::get('/getReports', 'adminPagesController@getReports');
            Route::get('/carryOver', 'adminPagesController@viewCarryOver');
            Route::get('/admin/do/carryOver', 'adminPagesController@carryOver');

            Route::get('/dataTable', 'adminPagesController@dataTables');
            Route::get('/adminGetUser/{id}','adminPagesController@adminGetUser');

            Route::post('/createPublicHoliday','adminPagesController@createPublicHoliday');
            Route::post('/editPublicHoliday','adminPagesController@editPublicHoliday');
            Route::post('/processPublicHolidays','adminPagesController@processPublicHolidays');
            /**
             * User specific Admin Routs
             */
             Route::get('/adminEmployeeLeaveSummary/{id}', 'adminEmployeePagesController@employeeLeaveSummary');
             Route::get('/confirmEmployee/{id}', 'adminEmployeePagesController@confirmEmployee');
             Route::post('/processEmployeeConfirmation/{id}','adminEmployeePagesController@processEmployeeConfirmation');
             Route::get('/adminAssignLineManager/{id}', 'adminEmployeePagesController@assignLineManager');
             Route::post('/assignLineManager/{id}', 'adminEmployeePagesController@processAssignLineManager');


    });


    //Compedium of Laravel's authentication routes
    Route::auth();

    //Logout Route
    Route::get('/logout', function () {
        Auth::logout();
        Session::flush();
        return Redirect::to('/login');
    });
