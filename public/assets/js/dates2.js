function workingDaysExcludingHolidays(startDate, endDate) {

    var holidates = [];
    var milliHolidays = [];
    var holidays = app.holidays;

    //Converting the holidays to milliseconds elapsed since epoch
    for (var i = 0; i < holidays.length; i++)
    {
       holidates.push( new Date(holidays[i]) );
       milliHolidays.push( holidates[i].getTime() );
    }

    //Converting the start and end dates to milliseconds since epoch
    var x = startDate.getTime();
    var y = endDate.getTime();
    var noOfHolidays = 0;

    //Looping through the holidays and checking if any occur with our date range
    for (var j = 0; j < milliHolidays.length; j++)
    {
        if( (milliHolidays[i] >= x ) && (milliHolidays[i] <= y) )
        {
            //Incrementing the noOfHolidays in our dateRange if any found
			noOfHolidays = noOfHolidays + 1;
        }

    }

    //Validating input to ensure startDate isn't greater than endDate
    if(endDate < startDate)
    {
        return -1;
    }

    if(endDate >= startDate)
    {
        var millisecondsPerDay = 86400 * 1000; // Day in milliseconds
        startDate.setHours(0,0,0,1);  // Start just after midnight
        endDate.setHours(23,59,59,999);  // End just before midnight
        var diff = endDate - startDate;  // Milliseconds between datetime objects
        var days = Math.ceil(diff / millisecondsPerDay);

        // Subtract two weekend days for every week in between
        var weeks = Math.floor(days / 7);
        days = days - (weeks * 2);

        // Handle special cases
        var startDay = startDate.getDay();
        var endDay = endDate.getDay();

        // Remove weekend not previously removed.
        if (startDay - endDay > 1)
            days = days - 2;

        // Remove start day if span starts on Sunday but ends before Saturday
        if (startDay == 0 && endDay != 6)
            days = days - 1;

        // Remove end day if span ends on Saturday but starts after Sunday
        if (endDay == 6 && startDay != 0)
            days = days - 1;

       return days - noOfHolidays;

    }
}


function ajaxCalcDate() {
    var startDate = moment( $('#startDate').val() );
	var endDate = moment (  $('#endDate').val()   );

    if(window.XMLHttpRequest)
    {
        var xmlhttp = new XMLHttpRequest();
    }else{
        var xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
    }

    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            var d1 = new Date( $('#startDate').val() );
            var d2 = new Date( $('#endDate').val() );
            var leaveType = $('#leaveType').val();

            /**
             * Code for maternity leave,because it includes weekends
             * and public holidays
             */
            if( leaveType === "Maternity" )
            {
                //If the startdate is after the enddate
                if(d2 < d1)
                {
                    $('#noOfDays').val('Invalid date range');
                }

                if(d2 > d1)
                {
                     var number = (d2 - d1)/86400000 + 1;
                     var day = " day(s)";
                     if ( isNaN(number) )
                     {
                        $('#noOfDays').val('Invalid date range');
                     }

                     if( !isNaN(number) )
                     {
                         $('#noOfDays').val( number + day );
                     }
                }


            }

            /**
             * Code for other leave types except for maternity leave.
             */
            if( leaveType !== "Maternity")
            {
                var diff = workingDaysExcludingHolidays( d1 , d2 );
                console.log(diff);
                var day = "";

                if( isNaN(diff) )
                {
                   console.log("Diff is not  a number");
                   diff = "Invalid date range";
                   day = "";
                   $('#noOfDays').val(diff+day) ;
                }

                //If the diff is a number
                if ( !isNaN(diff) )
                {
                     //console.log("Diff is a number");
                    if( diff < 1)
                    {
                         console.log("Diff is NEGATIVE");
                       diff = "Invalid date range";
                       day = "";
                    }

                    if( diff > app.maxNoOfDays && !isNaN(diff) && ( $('#leaveType').val() === "Annual") )
                    {
                         console.log("Diff is GREATER");
                        diff = "Exceeds max no of days";
                        day = "";
                    }

                    if( diff == 1)
                    {
                        day = " day";
                    }

                    if (diff > 1)
                    {
                        day = " days";
                    }

                    $('#noOfDays').val(diff+day) ;
                }
            }
        }//End of status 200
    }

    var here = window.location;
    xmlhttp.open('GET', here , true);
    xmlhttp.send();

}// EOF Ajaxcalcdate fn

function toggleNav() {
    document.getElementsByClassName("sidebar")[0].classList.toggle("responsive");
}

jQuery(document).ready(function($) {
	$('#startDate').datetimepicker({
		 timepicker:false,
		 format: 'Y-m-d',
		 minDate: 0,
	});
	$('#endDate').datetimepicker({
		  timepicker:false,
		  format: 'Y-m-d',
		  minDate: 0,
	});
	$('#holidayDate').datetimepicker({
		  timepicker:false,
		  format: 'Y-m-d',

	});
	$('#editHolidayDate').datetimepicker({
		  timepicker:false,
		  format: 'Y-m-d',

	});

});
