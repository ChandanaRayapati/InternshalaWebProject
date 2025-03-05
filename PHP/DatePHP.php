<?php

//Created my own function to display dates in dd mmm yyyy format.
function getactualdate($d,$s){
    
    $year=$d[0].$d[1].$d[2].$d[3];
    $mo=$d[5].$d[6];
    $month="";
    $da=$d[8].$d[9];
    $day="";
     
    //Using switch case to get mmm.
    switch($mo){
        case "01":$month="Jan";break;
        case "02":$month="Feb";break;
        case "03":$month="Mar";break;
        case "04":$month="Apr";break;
        case "05":$month="May";break;
        case "06":$month="Jun";break;
        case "07":$month="Jul";break;
        case "08":$month="Aug";break;
        case "09":$month="Sep";break;
        case "10":$month="Oct";break;
        case "11":$month="Nov";break;
        case "12":$month="Dec";break;
        default :$month=$mo;
    }
    
    $extras="";//like st,nd,rd and th (Eg.21st)
    if($da==="01" || $da==="21" || $da==="31"){
        $extras="st";
    }
    elseif ($da==="02" || $da==="22") {
        $extras="nd";
    }
    elseif ($da==="03" || $da==="23") {
        $extras="rd";
    }
    else{
        $extras="th";
    }
    
    //Removing zero for dates below 10.
    if($da=="01" ||$da=="02" ||$da=="03" ||$da=="04" ||$da=="05" ||$da=="06" ||$da=="07" ||$da=="08" ||$da=="09" ){
        $day=$da[1];
    }
    else{
        $day=$da;
    }
    
    //Giving seperate outputs for from and to dates.
    if($s==0){
        $date=$day.$extras." ".$month;
    }
    else{
        $date=$day.$extras." ".$month." ".$year;
    }    
    return $date;    
}
?>
