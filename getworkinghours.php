<?php 

/**
 * This function returns the working hours in seconds from two provide UTC strings.
 * @param  string $t1     The first time interval - e.g. 2014-12-25H12:43:24UTC
 * @param  string $t2     The second time interval
 * @return string         The number of seconds in working hours.
 */
function getworkinghours($t1,$t2) //timestring from array - e.g. 2014-12-25H12:43:24UTC blah blah
{

/*
Notes on this function:
______________________________________________________________________________
This script uses the ISO standard numeric assignment for days - 0 = sunday and 6 = saturday so we assume counting 1-5. Change to include saturday if you want!

The idea here is to split the date range in to individual days - first day (t1 date) starting at 00:00 and end day (t2 date) ending at 23:59

We can then look at each day through an array, and apply logic to count. Note that all calculations are using seconds - not other units!

*/
define('DAY_WORK', 30600); // 8.5h * 60m * 60s -> number of seconds in a working day
define('HOUR_START_DAY', '09:00:00');
define('HOUR_END_DAY', '17:30:00'); 


	//create an array of days covering the time period t1 to t2
	$startperiod = new datetime(gmdate("Y-m-d 00:00:00",$t1)); //this should be midnight on start date
	$endperiod = new datetime(gmdate("Y-m-d 23:59:59",$t2));  //this should be the end date
	$interval = new DateInterval('P1D');
	$period = new DatePeriod($startperiod, $interval, $endperiod);

	//loop for each day...
	$timespent = 0;
	foreach($period as $date)
	{
		if ($date->format('w')>0 && $date->format('w')<6)//adjust to different days if you want! - 0 = sun, 6 = sat
		{
			    	
				    $startofworkingday = $date->format('Y-m-d '. HOUR_START_DAY);
				    $endofworkingday = $date->format('Y-m-d '. HOUR_END_DAY);			    		


			        $startofworkingday = strtotime($startofworkingday);
			        $endofworkingday = strtotime($endofworkingday);

					//step 1: //for the first working day!!!!
					if ($date->format('Y-m-d') == gmdate('Y-m-d',$t1)) 
				    {				       
				        if ($t1 > $startofworkingday  && $t2 < $endofworkingday) 
				        		{
				        			$timespent = $timespent + $t2 - $t1; 
				        		}
				        elseif ($t1 > $startofworkingday && $t2 > $endofworkingday && $t1 < $endofworkingday) 
				        		{
				        			$timespent = $timespent + $endofworkingday - $t1;
				        		}
				        else 
				        		{
				        			$timespent = $timespent + 0;
				        		}
				    }

				    //step 2: Counting all complete working days
				    if ($date->format('Y-m-d') > gmdate('Y-m-d',$t1) && $date->format('Y-m-d') < gmdate('Y-m-d',$t2) )
					    {					    	
					    	$timespent = $timespent + DAY_WORK;
					    }

					//step 3 - counting the final day
					if ($date->format('Y-m-d') == gmdate('Y-m-d',$t2) && gmdate('Y-m-d',$t1) != gmdate('Y-m-d',$t2)) 
					{
					    	if ($t2 > $startofworkingday && $t2 < $endofworkingday)
						    	{
						    		$timespent = $timespent + $t2 - $startofworkingday;
						    	}
					    	elseif ($t2 > $startofworkingday && $t2 > $endofworkingday)
						    	{
						    		$timespent = $timespent + DAY_WORK;						    	}

					}
		}		
	}
return $timespent;
}
?>