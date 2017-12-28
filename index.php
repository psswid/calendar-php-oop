<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Calendar{
  private $month;
  private $year;
  private $days_of_week;
  private $num_days;
  private $date_info;
  private $day_of_week;

  public function __construct($month, $year, $days_of_week = array('Nd', 'Pon', 'Wt', 'Sr', 'Czw', 'Pt', 'Sob') ) {
//calendar setup
    $this->month = $month;
    $this->year = $year;
    $this->days_of_week = $days_of_week;
    $this->num_days = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
    $this->date_info = getdate(strtotime('first day of', mktime(0, 0, 0, $this->month, 1, $this->year)));
    $this->day_of_week = $this->date_info['wday'];
  }

  public function show() {
    //Month and year caption
    $output = '<table class="calendar">';
    $output .='<caption>'.$this->date_info['month'] .' ' . $this->year.'</caption>';
    $output .='</tr>';

    //Days of the week header
    foreach($this->days_of_week as $day) {
      $output .= '<th class="header">' . $day . '</th>';
    }
    //Close header row and open first row of days_of_week
    $output .='</tr><tr>';

    //If first day of a month is not on a Sunday, beggining space will be colspan
    if ($this->day_of_week > 0 ) {
      $output .= '<td colspan="' . ($this->day_of_week) . '"></td>';
    }

    //Start num_days counter
    $current_day = 1;

    //Loop and build days
    while ( $current_day <= $this->num_days){
      //Reset day of week counter and closea each row if end of row
      if ( $this->day_of_week == 7 ) {
        $this->day_of_week = 0;
        $output .= '</tr><tr>';
      }
      //Build each day cell
      $output .= '<td class="day">' . $current_day . '</td>';

      //Counters
      $current_day++;
      $this->day_of_week++;
    }
    //When num_days counter stops, if day of week counter != 7, fill remaining spaces of row with colspan
    if ( $this->day_of_week != 7) {
      $remaining_days = 7 - $this->day_of_week;
      $output .= '<td colspan="' . $remaining_days . '"></td>';
    }
     //close row and table
     $output .= '</tr>';
     $output .= '</table>';

     echo $output;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
  <title>Calendar</title>
</head>
<body>
  <?php
  //$month = $_GET['m'];

  // echo "Today is: ";
  // echo date("d m Y");'<br \>';
  echo '<h1>Today is</h1>';
  echo '<br \>';
  echo date("d m Y").'<br \>'.'<br \>';
  $today = getdate();
  print_r($today);
  echo '<br \><br \>';


  $calendar = new Calendar(6,2016);
  $calendar->show();
  ?>
</body>
</html>
