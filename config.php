<?php
    
$con = new PDO("mysql:host=localhost;dbname=link", "root", "");

date_default_timezone_set("Asia/Kolkata");

function get_not_empty($val){
    if($val != ""){
        return intval($val);
    }else{
        return -1;
    }
}

$days = array(
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thursday",
    "Friday",
    "Saturday",
);

$lectures = array(
    "Lec 1",
    "Lec 2",
    "Lec 3",
    "Lec 4",
);