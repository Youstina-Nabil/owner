<?php

session_start();
//connection
$user='root';
$pass='';
$db='customer_side_db';
$connect=new mysqli('localhost',$user,$pass,$db) or die("Unable to connect");



 if(!empty($_POST['latitude']) &&($_POST['longitudes']) ) {
    $_SESSION['latitude'] = $_POST['latitude'];
    $_SESSION['longitudes'] = $_POST['longitudes']; 
   
 } 
  
// $busno = $_SESSION['Bus_no'];
// echo $busno;
  $buslinename=   $_SESSION['Redraw_Bus_line_name'];
   $busno=         $_SESSION['Redraw_Bus_No'] ;
   
   
   //echo "Favorite color is " . $_SESSION["Redraw_Bus_line_name"] . ".<br>";
   //echo "Favorite color is " .  $_SESSION['Redraw_Bus_No'] . ".<br>";
 

  
  

 //ternary logic --> (condition) ? true : false
 $latitudes = (isset($_SESSION['latitude']) && $_SESSION['latitude'] != '') ? $_SESSION['latitude'] : $_POST['latitude'];
 $longitudes = (isset($_SESSION['longitudes']) && $_SESSION['longitudes'] != '') ? $_SESSION['longitudes'] : $_POST['longitudes'];

 
 
 //from queries
 
// $queryLineNameNumber = mysqli_query($connect," SELECT bus.GeofenceId, bus.GeofenceName FROM bus WHERE (bus.BusNo='$busno')and(bus.LicensePlate='$plate') " );  
//
// 
// if($queryGeoIDandName === FALSE) { 
//    die('Could not get geofence  ' . mysql_error());
//}
// 
//while($rows=  mysqli_fetch_array($queryGeoIDandName)){
//    $GeofenceId= $rows['GeofenceId'];
//    $GeofenceName= $rows['GeofenceName'];  
//}
//
//echo $GeofenceId;
//echo $GeofenceName;

// $querycompanyAndOwner = mysqli_query($connect," SELECT bus.GrandCompanyName, bus.OwnerUserName FROM bus WHERE (bus.BusNo='$busno')and(bus.LicensePlate='$plate') " );  
//
// if($querycompanyAndOwner === FALSE) { 
//    die('Could not get geofence  ' . mysql_error());
//}
// 
//while($rows=  mysqli_fetch_array($querycompanyAndOwner)){
//    $CompanyName= $rows['GrandCompanyName'];
//    $OwnerUserName= $rows['OwnerUserName'];  
//}
//
//echo $CompanyName;
//echo $OwnerUserName;

// $GeofenceId=12;
// $GeofenceName="abasya";
// $CompanyName="hebatravel";
// $OwnerUserName="heba14";
 

//delete the points already there
$querydelete = mysqli_query($connect,"DELETE FROM `points` WHERE  (`BusLineName`='$buslinename') and (`BusNo`='$busno')" );


if($querydelete === FALSE) { 
    die('Could not delete already existing coordinates ' . mysql_error());
}
       


 foreach($latitudes as $index => $value) {
     
    
    echo "<h3>" . $latitudes[$index] . "</h3>";
    echo "<h3>" . $longitudes[$index] . "</h3>";
   
       
    //$sql ="INSERT INTO `points`(`GeofenceId`, `GeofenceName`, `Latitude`, `Longitude`, `CompanyName`, `OwnerUserName`, `PointId`) VALUES ($GeofenceId,'$GeofenceName',$latitudes[$index],$longitudes[$index],'$CompanyName','$OwnerUserName','$index')";
    $sql ="INSERT INTO `points`(`PointId`, `BusLineName`, `BusNo`, `Latitude`, `Longitude`) VALUES ($index,'$buslinename',$busno,$latitudes[$index],$longitudes[$index])";
    echo $sql;
   $query=  mysqli_query($connect,$sql);
    if($query){
        echo " your message have been recorded";
    }
    
   else {
   
       echo 'Please enter you message'; 
   }
}
?>
