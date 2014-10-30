<?php 

/**
 * This function returns the working hours in seconds from two provide UTC strings.
 * @param  string $timeOne     The first time interval - e.g. 2014-12-25H12:43:24UTC
 * @param  string $timeTwo     The second time interval
 * @return string         The number of seconds in working hours.
 */
function getworkinghours($timeOne,$timeTwo) 
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
    $startperiod = new datetime(gmdate("Y-m-d 00:00:00", $timeOne)); //this should be midnight on start date
    $endperiod = new datetime(gmdate("Y-m-d 23:59:59", $timeTwo));  //this should be the end date
    $interval = new DateInterval('P1D');
    $period = new DatePeriod($startperiod, $interval, $endperiod);

    //loop for each day...
    $timespent = 0;
    foreach($period as $date) {

        if ($date->format('w')>0 && $date->format('w')<6) {
                    
                    $startofworkingday = $date->format('Y-m-d '. HOUR_START_DAY);
                    $endofworkingday = $date->format('Y-m-d '. HOUR_END_DAY);                        

                    $startofworkingday = strtotime($startofworkingday);
                    $endofworkingday = strtotime($endofworkingday);

                    //step 1: //for the first working day!!!!
                    if ($date->format('Y-m-d') == gmdate('Y-m-d', $timeOne)) {                       
                        if ($timeOne > $startofworkingday  && $timeTwo < $endofworkingday) {
                            $timespent = $timespent + $timeTwo - $timeOne; 
                        } elseif ($timeOne > $startofworkingday && $timeTwo > $endofworkingday && $timeOne < $endofworkingday) {
                            $timespent = $timespent + $endofworkingday - $timeOne;
                        } else {
                            $timespent = $timespent + 0;
                        }
                    }

                    //step 2: Counting all complete working days
                    if ($date->format('Y-m-d') > gmdate('Y-m-d', $timeOne) && $date->format('Y-m-d') < gmdate('Y-m-d', $timeTwo) ) {                            
                        $timespent = $timespent + DAY_WORK;
                    }

                    //step 3 - counting the final day
                    if ($date->format('Y-m-d') == gmdate('Y-m-d', $timeTwo) && gmdate('Y-m-d', $timeOne) != gmdate('Y-m-d', $timeTwo)) {
                            if ($timeTwo > $startofworkingday && $timeTwo < $endofworkingday) {
                                $timespent = $timespent + $timeTwo - $startofworkingday;
                            } elseif ($timeTwo > $startofworkingday && $timeTwo > $endofworkingday) {
                                $timespent = $timespent + DAY_WORK;                               
                            }
                    }
        }        
    }
return $timespent;
}
?>
