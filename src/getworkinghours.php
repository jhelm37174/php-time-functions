<?php
/**
 * Get Working Time function.
 *
 * This file contains a single function - get working time. This function is 
 * useful if you need to calculate how long a specific task has been open 
 * during working time. For example, if you work in a service desk, and 
 * you need to review all the tickets to see which has been open for more 
 * than X hours during your normal office hours so that you can prioritize
 * work.
 *
 */


/**
 * The DAY_WORK represents the number of working seconds in a day.
 * e.g. 8.5 hour working day is 30600 seconds.
 */
define('DAY_WORK', 30600);
/**
 * The HOUR_START_DAY represents the start of the working day -
 * e.g. 09:00 in 24 hr format.
 */
define('HOUR_START_DAY', '09:00:00');
/**
 * The HOUR_END_DAY represents the end of the working day - e.g. 18:00 in
 * 24 hr format.
 */
define('HOUR_END_DAY', '17:30:00');

/**
 * The GetWorkingHours function accepts two timestamp inputs and returns a 
 * time in seconds. It calculates this by splitting the date range provided 
 * in $timeOne and $timeTwo in to days and then loop each day through an array.
 * Saturdays and Sundays are excluded as working days, 
 *
 * 
 * @param  int $timeOne a Unix timestamp - e.g. 1414666350
 * @param  int $timeTwo a Unix timestamp - e.g. 1414666390 - second must be
 * greater than the first
 * @return int time in seconds
 */
function getworkinghours($timeOne, $timeTwo)
{

/*
Notes on this function:
______________________________________________________________________________
This script uses the ISO standard numeric assignment for days - 0 = sunday and 
6 = saturday so we assume counting 1-5.

The idea here is to split the date range in to individual days - first day 
(timeOne date) starting at 00:00 and end day (timeTwo date) ending at 23:59

We can then look at each day through an array, and apply logic to count. 
Note that all calculations are using seconds - not other units!

*/



    //create an array of days covering the time period t1 to t2
    $startperiod = new datetime(gmdate("Y-m-d 00:00:00", $timeOne));
    $endperiod = new datetime(gmdate("Y-m-d 23:59:59", $timeTwo));
    $interval = new DateInterval('P1D');
    $period = new DatePeriod($startperiod, $interval, $endperiod);

    //loop for each day...
    $timespent = 0;
    foreach ($period as $date) {

        if ($date->format('w')>0 && $date->format('w')<6) {
                    
            $startofworkingday = $date->format('Y-m-d '. HOUR_START_DAY);
            $endofworkingday = $date->format('Y-m-d '. HOUR_END_DAY);

            $startofworkingday = strtotime($startofworkingday);
            $endofworkingday = strtotime($endofworkingday);

            //step 1: //for the first working day!!!!
            if ($date->format('Y-m-d') == gmdate('Y-m-d', $timeOne)) {
              if ($timeOne > $startofworkingday  &&
                $timeTwo < $endofworkingday) {
                $timespent = $timespent + $timeTwo - $timeOne;
              } elseif ($timeOne > $startofworkingday &&
                $timeTwo > $endofworkingday && $timeOne < $endofworkingday) {
                $timespent = $timespent + $endofworkingday - $timeOne;
              } else {
                $timespent = $timespent + 0;
              }
            }

            //step 2: Counting all complete working days
            if ($date->format('Y-m-d') > gmdate('Y-m-d', $timeOne) 
                 && $date->format('Y-m-d') < gmdate('Y-m-d', $timeTwo)) {
                  $timespent = $timespent + DAY_WORK;
            }

            //step 3 - counting the final day
            if ($date->format('Y-m-d') == gmdate('Y-m-d', $timeTwo) && 
              gmdate('Y-m-d', $timeOne) != gmdate('Y-m-d', $timeTwo)) {
              if ($timeTwo > $startofworkingday &&
                $timeTwo < $endofworkingday) {
                $timespent = $timespent + $timeTwo - $startofworkingday;
              } elseif ($timeTwo > $startofworkingday &&
                $timeTwo > $endofworkingday) {
                $timespent = $timespent + DAY_WORK;
              }
            }
        }
    }
  return $timespent;
}
