<?php
//error_reporting(0);
function getTimezoneOffset($timezone){ 
  $current   = timezone_open($timezone); 
  $utcTime  = new \DateTime('now', new \DateTimeZone('UTC')); 
  $offsetInSecs =  timezone_offset_get($current, $utcTime); 
  $hoursAndSec = gmdate('H:i', abs($offsetInSecs)); 
  return stripos($offsetInSecs, '-') === false ? "+{$hoursAndSec}" : "-{$hoursAndSec}"; 
} 
  
if(isset($_POST['modify_data'])){
    if($_POST['_start']==null){
        $start= "";
    } else {
        $ex_=explode("T",$_POST['_start']);
        $ex_n = explode("+",$ex_[1]);
        $start= $ex_[0]." ".date("g:i:s A", strtotime($ex_n[0]));
    }
    if($_POST['_end']==null){
        $end= "";
    } else {
        $ex_1=explode("T",$_POST['_end']);
        $ex_n1 = explode("+",$ex_1[1]);
        $end= $ex_1[0]." ".date("g:i:s A", strtotime($ex_n1[0]));
    }
    $event = array('start' => $start, 'end' => $end);
    echo json_encode($event);
}
if(isset($_POST['addevent'])){
$timezone_offset = getTimezoneOffset($_POST['timezone']); 
$timezone_offset = !empty($timezone_offset)?$timezone_offset:'07:00'; 
    $date = date("Y-m-d", strtotime($_POST['date']));
    $starttime = $_POST['starttime'].":00";
    $endtime = $_POST['endtime'].":00";
    $summary = $_POST['summary'];
    $location = $_POST['location'];
    $description = $_POST['description'];
$event = array('start' => $date.'T'.$starttime.$timezone_offset, 'end' => $date.'T'.$endtime.$timezone_offset);
echo json_encode($event);
}
?>
