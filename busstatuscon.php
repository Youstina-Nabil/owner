<?php    
header('Location: busstatus.php');    
?>
<?php
session_start();
?>
<!DOCTYPE html>
<html>
   
    
<title> Buses </title>
<div class="col-lg-1"></div>
<div class="col-lg-2"></div>
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  
  
  
  
  
  
  
  
  
  
  
    
    
    
    
</head>
<link rel="stylesheet" href="style1.css">
 
<div class="col-lg-6" >
       
            <body>
                
                
                
                
                
                
          
                
                
                
      <div style="margin-top: 100px">          

<table class="table table-striped">
<tr>
      <th>status</th>
      
      </tr>
     

<?php

  $db1 = new mysqli('localhost','root','','customer_side_db');
  $db2 = new mysqli('localhost','root','','device_database');
if ($db1->connect_error) {
    die("Connection failed: " . $db1->connect_error);
} 
if ($db2->connect_error) {
    die("Connection failed: " . $db2->connect_error);
} 
$user=$_SESSION["username"];
$companyname =$_SESSION["cname"] ;
$sqlStatus1 = ("UPDATE bus SET BusStatus = 'Working' " );
$resultS1 = $db1->query($sqlStatus1);

$counter=1;

$sql = ("SELECT DISTINCT LicensePlate,DeviceUniqueId FROM bus Where OwnerUserName='$user' AND CompanyName='$companyname' ");
$result = $db1->query($sql);

if($result ==null)
{echo '<strong>There is No buses in your fleet</strong>';}
else{
while($row = $result->fetch_assoc()) 
{ 
$LP=$row['LicensePlate'] ;
//echo $LP;
$L=$row['DeviceUniqueId'] ;
//echo $Speed;
//print "<tr>";

 $sqljoin="SELECT * 
  From customer_side_db.bus INNER JOIN device_database.devices 
  ON customer_side_db.bus.DeviceUniqueId= device_database.devices.uniqueid
  INNER JOIN device_database.positions 
  ON  device_database.devices.id = device_database.positions.deviceid
  WHERE customer_side_db.bus.DeviceUniqueId=$L
  ORDER BY device_database.positions.devicetime DESC
  LIMIT 1 ";
  $resultjoin =($db1->query($sqljoin) ) AND ($db2->query($sqljoin));
  if($resultjoin == null  )
{echo '<strong><h4>There is No tracked buses</strong></h4>';}
else{

  while($row = $resultjoin->fetch_assoc()) 
  {$timeNow = date("Y-m-d");
//echo $timeNow ."<br>";
//$counter=1;
 
$datetime1 = new DateTime($row['TireLastChangeDate']);
$datetime2 = new DateTime($timeNow );
$datetime3 = new DateTime($row['LastMaintenanceDate']);
$interval = $datetime1->diff($datetime2);
$interval2 = $datetime3->diff($datetime2);
if ($interval->format('%R%a days') >=  90 || $interval2->format('%R%a days') >=  90)
{
$ok= '0';
//echo "ok : ".$ok ."<br>";
}
else
{
$ok = 'Working';
//echo "ok : ".$ok ."<br>";
}

$sqlStatus1 = ("UPDATE bus SET BusStatus =$ok WHERE ID=$counter" );
$resultS1 =$db1->query($sqlStatus1);
$sqlStatus = ("UPDATE bus SET BusStatus =	'Not Working Correctly' WHERE  BusStatus = '0' " );//($Speed > $SpeedLimit)  ||(FuelLevel < 0.33*FuelCapacity) ||
$resultS = $db1->query($sqlStatus);

$SpeedLimit=$row['SpeedLimit'];
$Speed=$row['speed'];
$fuelcap=$row['FuelCapacity'];
$attr =$row['attributes'];
//fuel
$fuel1 =strchr($attr,"adc1");
$fuel2 =strchr($fuel1,",",1);
$fuel =strchr($fuel2,":",0);
$fuel =ltrim($fuel,':');
$fuellevel= ((1024-$fuel)/1024)*100;

//oil
$oil1 =strchr($attr,"adc2");
$oil2 =strchr($oil1,",",1);
$oil =strchr($oil2,":",0);
$oil =ltrim($oil,':');
$oillevel= ((1024-$oil)/1024)*100;


//echo "level :".$fuellevel ;
$sqlStatus = ("UPDATE bus SET FuelLevel =	$fuel where ID =$counter");//($Speed > $SpeedLimit)  ||
$resultS = $db1->query($sqlStatus);

if($Speed > $SpeedLimit)
{
//echo "c :".$counter ."bs";
$sqlStatus1 = ("UPDATE bus SET BusStatus = 'Not Working Correctly' WHERE ID =$counter" );
$resultS1 =$db1->query($sqlStatus1);
}

if($fuellevel < 10)
{
//echo "c :".$counter ."bs";
$sqlStatus2 = ("UPDATE bus SET BusStatus = 'Not Working Correctly' WHERE ID =$counter" );
$resultS2=$db1->query($sqlStatus2);
}

if($oillevel < 40)
{
//echo "c :".$counter ."bs";
$sqlStatus2 = ("UPDATE bus SET BusStatus = 'Not Working Correctly' WHERE ID =$counter" );
$resultS2=$db1->query($sqlStatus2);
}
 print "<tr>"; 

//print "<td>" . $row['attributes'] . "</td></tr>"; 

}

$counter=$counter+1;
}}}
 
?>
</table>
          </div>
 
</div>

 <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
</html>


<html>
    
    <head>
        
        <style>.nav-side-menu {
  overflow: auto;
  font-family: verdana;
  font-size: 12px;
  font-weight: 200;
  background-color: #2e353d;
  position: fixed;
  top: 0px;
  width: 300px;
  height: 100%;
  color: #e1ffff;
}
.nav-side-menu .brand {
  background-color: #23282e;
  line-height: 50px;
  display: block;
  text-align: center;
  font-size: 14px;
}
.nav-side-menu .toggle-btn {
  display: none;
}
.nav-side-menu ul,
.nav-side-menu li {
  list-style: none;
  padding: 0px;
  margin: 0px;
  line-height: 35px;
  cursor: pointer;
  /*    
    .collapsed{
       .arrow:before{
                 font-family: FontAwesome;
                 content: "\f053";
                 display: inline-block;
                 padding-left:10px;
                 padding-right: 10px;
                 vertical-align: middle;
                 float:right;
            }
     }
*/
}
.nav-side-menu ul :not(collapsed) .arrow:before,
.nav-side-menu li :not(collapsed) .arrow:before {
  font-family: FontAwesome;
  content: "\f078";
  display: inline-block;
  padding-left: 10px;
  padding-right: 10px;
  vertical-align: middle;
  float: right;
}
.nav-side-menu ul .active,
.nav-side-menu li .active {
  border-left: 3px solid #d19b3d;
  background-color: #4f5b69;
}
.nav-side-menu ul .sub-menu li.active,
.nav-side-menu li .sub-menu li.active {
  color: #d19b3d;
}
.nav-side-menu ul .sub-menu li.active a,
.nav-side-menu li .sub-menu li.active a {
  color: #d19b3d;
}
.nav-side-menu ul .sub-menu li,
.nav-side-menu li .sub-menu li {
  background-color: #181c20;
  border: none;
  line-height: 28px;
  border-bottom: 1px solid #23282e;
  margin-left: 0px;
}
.nav-side-menu ul .sub-menu li:hover,
.nav-side-menu li .sub-menu li:hover {
  background-color: #020203;
}
.nav-side-menu ul .sub-menu li:before,
.nav-side-menu li .sub-menu li:before {
  font-family: FontAwesome;
  content: "\f105";
  display: inline-block;
  padding-left: 10px;
  padding-right: 10px;
  vertical-align: middle;
}
.nav-side-menu li {
  padding-left: 0px;
  border-left: 3px solid #2e353d;
  border-bottom: 1px solid #23282e;
}
.nav-side-menu li a {
  text-decoration: none;
  color: #e1ffff;
}
.nav-side-menu li a i {
  padding-left: 10px;
  width: 20px;
  padding-right: 20px;
}
.nav-side-menu li:hover {
  border-left: 3px solid #d19b3d;
  background-color: #4f5b69;
  -webkit-transition: all 1s ease;
  -moz-transition: all 1s ease;
  -o-transition: all 1s ease;
  -ms-transition: all 1s ease;
  transition: all 1s ease;
}
@media (max-width: 767px) {
  .nav-side-menu {
    position: relative;
    width: 100%;
    margin-bottom: 10px;
  }
  .nav-side-menu .toggle-btn {
    display: block;
    cursor: pointer;
    position: absolute;
    right: 10px;
    top: 10px;
    z-index: 10 !important;
    padding: 3px;
    background-color: #ffffff;
    color: #000;
    width: 40px;
    text-align: center;
  }
  .brand {
    text-align: left !important;
    font-size: 22px;
    padding-left: 20px;
    line-height: 50px !important;
  }
}
@media (min-width: 767px) {
  .nav-side-menu .menu-list .menu-content {
    display: block;
  }
}
body {
  margin: 0px;
  padding: 0px;
}
</style>
        
        
    </head>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

<div class="nav-side-menu">
    <div class="brand"><b>Tracking system </div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
  
        <div class="menu-list">
  
            <ul id="menu-content" class="menu-content collapse out">
                <li>
                  <a href="homepage.php">
                  <i class="fa fa-dashboard fa-lg"></i> Home
                  </a>
                </li>

                <li>
                     <a href="personal.php">
                  <i class="fa fa-user fa-lg"></i> Profile
                  </a>
                  </li>


               


                <li data-toggle="collapse" data-target="#new" class="collapsed">
                  <i class="fa fa-car fa-lg"></i> My Busses <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="new">
                 <a href="ownerhomeupdate.php"> <li>ADD/Remove bus</li>
                 <a href="BuStatus.php"> <li>Bus status and reports </li>
                
                </ul>


                 

                 <li>
                     <a href="ownerhome21.php ">
                  <i class="fa fa-users fa-lg"></i> Managers
                  </a>
                </li>
                 <li>
                  <a href="ownerhome31.php">
                  <i class="glyphicon glyphicon-search"></i> search Busses
                  </a>
                  </li>
            </ul>
     </div>
</div
</html>