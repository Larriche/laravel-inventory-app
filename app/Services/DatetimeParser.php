<?php
namespace App\Services;

class DatetimeParser
{
	/**
	 * This class is used for generating a MySQL datetime field from
	 * a combination of date and time selected using Bootstrap date and time
	 * picker
	 */
	
    /** 
     * Convert date and time selected using Bootstrap picker
     * into MySQL datetime format
     * 
     * @return string the datetime
     */
	public static function getDateTime($date, $time = null)
	{
		$dateParts = explode("/", $date);
		$date = $dateParts[count($dateParts) - 1]."-".$dateParts[0]."-".$dateParts[1];

        if ($time) {
			$timeParts = explode(" ", $time);
			$hourMin = explode(":", $timeParts[0]);
			$hour = $hourMin[0];
			$minute = $hourMin[1];
			$period = $timeParts[ count($timeParts) - 1 ];
	        
	        if ( $period == "PM" ) {
	        	$hour = (int)$hour + 12;
	        }

	        return $date." ".$hour.":".$minute.":"."00";
        }

        return $date;
	}

    /**
     * Convert datetime obtained from MySQL into format that can be used 
     * to set picker form fields
     * 
     * @return array the date and time as seperate components
     */
	public static function getPickerDateTime($dateTime)
	{
		$datetimeParts = explode(" ",$dateTime);
		$date = $datetimeParts[0];
		$time = $datetimeParts[1];

		$dateParts = explode("-", $date);
		$convertedDate = $dateParts[1].'/'.$dateParts[count($dateParts) - 1].'/'.$dateParts[0];

		$timeParts = explode(":", $time);
		$hour = $timeParts[0];
		$minute = $timeParts[1];

		if((int)$hour > 12){
			$hour = (int)$hour - 12;
			$period = "PM";
		}
		else{
			$period = "AM";
		}

		$convertedTime = $hour . ":" . $minute. " " . $period;

		return [ $convertedDate, $convertedTime ];
	}
}