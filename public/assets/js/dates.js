function workingDaysExcludingHolidays(startDate, endDate) {

  	var holidates = []; var milliHolidays = [];
    var holidays = app.holidays;

		//Converting the holidays to milliseconds elapsed since epoch
		for(var i=0 ; i<holidays.length; i++)
			{
				 holidates.push(new Date(holidays[i]) ) ;
				 milliHolidays.push(holidates[i].getTime());
			}

		//Converting the d1 and d2 to milliseconds elapsed since epoch
		var x = startDate.getTime();
		var y = endDate.getTime();
		var noOfHolidays = 0;

		//Looping through the holidays and finding if any occur within our date range
		for (var i=0; i<milliHolidays.length; i++)
			{
				if(  (milliHolidays[i] >= x ) && (milliHolidays[i] <= y) )
				{
					//Incrementing the noOfHolidays in our dateRange if any found
					noOfHolidays = noOfHolidays + 1;
				}
			}

    // Validate input
    if (endDate < startDate)
        return -1;

    // Calculate days between dates
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
        days = days - 1

    // Remove end day if span ends on Saturday but starts after Sunday
    if (endDay == 6 && startDay != 0)
        days = days - 1

    return days - noOfHolidays;
}




function ajaxCalcDate(){
	var startDate = moment( $('#startDate').val() );
	var endDate = moment (  $('#endDate').val()   );
			if(window.XMLHttpRequest){
        	//alert("new windows");
				var xmlhttp = new XMLHttpRequest();
			}else{
				var xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
				//alert("old windows");
			}
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
					//alert("ready windows");
					//var startDate = moment( $('#startDate').val() );
				//	var endDate = moment (  $('#endDate').val()   );
					var d1 =  new Date($('#startDate').val() );
					var d2 = new  Date ( $('#endDate').val() );
					//var diff = endDate.diff(startDate, 'days');
					var leaveType = $('#leaveType').val();

					if(  leaveType === "Maternity" )
          {
            var ex = (d2-d1)/86400000 + 1;
            var day = " day(s)";
            if (isNaN(ex))
            {
                ex = "";
                day = "";
            }
            console.log("aaaaaa");
          	$('#noOfDays').val(ex+day) ;
          } else {

            var diff = workingDaysExcludingHolidays( d1 , d2 );


            var day = "";


            if(isNaN(diff))
            {

              diff = "";
              var day = "";
            }
						else{
                  if(diff < 1)
                  {
                    diff = "Invalid Date range";
                    var day = "";

                  }
                  if(diff > app.maxNoOfDays && !isNaN(diff))
                  {

                    diff = "Exceeds max no of days ";
                    var day = "";
                  }
                  if(diff == 1)
                  {
                  //diff += " day";
                  var day = " day";
                  }
                if(diff > 1){
                  //diff += " days";
                  var day = " days";
                }
            }

            $('#noOfDays').val(diff+day) ;


          }//END




				}
			}
			var here = window.location;
			xmlhttp.open('GET',here,true);
			xmlhttp.send();


}

function toggleNav() {
    document.getElementsByClassName("sidebar")[0].classList.toggle("responsive");
}

jQuery(document).ready(function($) {
	$('#startDate').datetimepicker({
		 timepicker:false,
		 format: 'Y-m-d',
		 //minDate: 0,
	});
	$('#endDate').datetimepicker({
		  timepicker:false,
		  format: 'Y-m-d',
		  ///minDate: 0,
	});
	$('#holidayDate').datetimepicker({
		  timepicker:false,
		  format: 'Y-m-d',

	});
	$('#editHolidayDate').datetimepicker({
		  timepicker:false,
		  format: 'Y-m-d',

	});

	//alert(moment().format('YYYY-MM-DD'));


});
