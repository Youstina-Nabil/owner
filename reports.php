<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <img  src="images/gr.png" class="img-responsive"   style='position:fixed;top:0px;left:0px;width:100%;height:100%;z-index:-1;' >
<title> Reports </title>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Vehicle Tracking System</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<link rel="stylesheet" href="style1.css">
<div class="col-lg-3"></div>
<div class="col-lg-6" style="margin:100px">
<body>

<table class="table table-striped">
 
<?php
  $db1 = new mysqli('localhost','root','','customer_side_db');
  $db2 = new mysqli('localhost','root','','device_database');
if ($db1->connect_error) {
    die("Connection failed: " . $db1->connect_error);
} 
if ($db2->connect_error) {
    die("Connection failed: " . $db2->connect_error);
} 
$counter = $_GET["ID"];
$LP = $_GET["LicensePlate"];
//echo $counter;
$LPL=rtrim($LP," </td");
//echo $LPL ."<br>";

$sqllink= ("SELECT * From Bus WHERE ID=$counter");
$resultlink = $db1->query($sqllink);
  if($resultlink ==null)
{echo '<h4><strong>There is No buses in your fleet</strong></h4>';}
else{
echo "<h3><strong>Bus details</strong></h3>";
while($row = $resultlink->fetch_assoc()) 
{ 
print "<tr><th>License Plate </th><td>" . $row['LicensePlate'] . "</td></tr>"; 
print "<tr><th>Bus type </th><td>" . $row['BusType'] . "</td></tr>"; 
//print "<tr><th>Geofence Name </th><td>" . $row['GeofenceName'] . "</td></tr>";
print "<tr><th>Sim Phone No </th><td>" . $row['SimPhoneNo'] . "</td></tr>";
print "<tr><th>Device Installation Time </th><td>" . $row['DeviceInstallationTime'] . "</td></tr>";
print "<tr><th>Device Reset Time </th><td>" . $row['DeviceResetTime'] . "</td></tr>";
} 
}
//bus yard
$sqlyard= ("SELECT BusyardName From contain WHERE BusLicensePlate='$LPL'");
$resultyard = $db1->query($sqlyard);
  if($resultyard ==null)
{echo '<h4><strong>There is No assigned Yard for this bus in your fleet</strong></h4>';}
else{
while($row = $resultyard->fetch_assoc()) 
{ 
print "<tr><th>Yard Name</th><td>" . $row['BusyardName'] . "</td></tr>"; 
}
}
//busline &busno
$sqlb= ("SELECT * From belongs_to WHERE BusLicensePlate='$LPL'");
$resultb = $db1->query($sqlb);
  if($resultb ==null)
{echo '<h4><strong>There is No assigned Yard for this bus in your fleet</strong></h4>';}
else{
while($row = $resultb->fetch_assoc()) 
{ 
print "<tr><th>Bus Line Name</th><td>" . $row['BusLineName'] . "</td></tr>"; 
print "<tr><th>Bus number</th><td>" . $row['BusNo'] . "</td></tr>"; 
}
}



//
//print "</table>";
//device
//echo '<table class="table table-striped">';
 $sqljoin="SELECT * 
  From customer_side_db.bus INNER JOIN device_database.devices 
  ON customer_side_db.bus.DeviceUniqueId= device_database.devices.uniqueid
  INNER JOIN device_database.positions 
  ON  device_database.devices.id = device_database.positions.deviceid
  WHERE customer_side_db.bus.LicensePlate='$LPL'
  ORDER BY device_database.positions.devicetime DESC
  LIMIT 1 ";
  $resultjoin =($db1->query($sqljoin) ) AND ($db2->query($sqljoin));
  if($resultjoin ==null)
{echo '<strong><h4>There is No device assigned for this bus in your fleet</strong></h4>';}
else{
//echo "<h3><strong>Device information</strong></h3>";
  while($row = $resultjoin->fetch_assoc()) 
{ 
$attr =$row['attributes'];
$SpeedLimit=$row['SpeedLimit'];
$Speed=$row['speed'];
//tire & maintenance
$timeNow = date("Y-m-d");
$datetime1 = new DateTime($row['TireLastChangeDate']);
$datetime2 = new DateTime($timeNow );
$datetime3 = new DateTime($row['LastMaintenanceDate']);
$interval = $datetime1->diff($datetime2);
$interval2 = $datetime3->diff($datetime2);

//fuel
$fuel1 =strchr($attr,"adc1");
$fuel2 =strchr($fuel1,",",1);
$fuel =strchr($fuel2,":",0);
$fuel =ltrim($fuel,':');
$fuellevel= ((1024-$fuel)/1024)*100;
if($fuellevel < 10)
{
$fuelErr='<font color="red">"Fuel Level is too low"</font>';
}
else{$fuelErr=$fuellevel;}
//oil
$oil1 =strchr($attr,"adc2");
$oil2 =strchr($oil1,",",1);
$oil =strchr($oil2,":",0);
$oil =ltrim($oil,':');
$oillevel= ((1024-$oil)/1024)*100;
if($oillevel < 40)
{
$oilErr='<font color="red">"Oil Level is too low"</font>';
}
else{$oilErr=$oillevel;}
//speed
if($Speed > $SpeedLimit)
{
$SpeedErr='<font color="red">"Speed Exceeds Speed Limit"</font>';
}
else{$SpeedErr=$Speed;}
//tire and maintenance
if($interval->format('%R%a days') >=  90 )
{
$tireErr='<font color="red">"You need to check your tires"</font>';
}
else{$tireErr=$interval->format('%R%a days');}
if($interval2->format('%R%a days') >=  90)
{
$maintenanceErr='<font color="red">"Your bus needs maintenance "</font>';
}
else{$maintenanceErr= $interval2->format('%R%a days');}

//processing bits
$status12 =strchr($attr,"status");
$status122 =strchr($status12,",",1);
$status1222 =strchr($status122,":",0);
$status1222 =trim($status1222,':"');
$sub1=substr($status1222,0,1);
$sub1 =base_convert($sub1,16,2);
//bit 12
if($sub1== 1 || $sub1== 11 || $sub1== 101|| $sub1== 111|| $sub1== 1001|| $sub1== 1011|| $sub1== 1101|| $sub1== 1111)
{
$temp= '<font color="red">"Temperature of engine is high"</font>';
}
else
{
$temp ="Temperature of engine is moderate";
}
//status bit 11,10,9,8
$sub2=substr($status1222,1,1);
$sub2 =base_convert($sub2,16,2);
//bit 11
$sub2=substr($status1222,1,1);
$sub2 =base_convert($sub2,16,2);
if($sub2==1000 || $sub2==1001 || $sub2==1010 || $sub2==1011 || $sub2==1100 || $sub2==1101 || $sub2==1110 || $sub2==1111)
{
$accident= '<font color="red">"Your Bus made accident!"</font>';
}
else
{
$accident ="Your bus is safe";
}
//bit 10
if($sub2==100 || $sub2==101 || $sub2==110 || $sub2==111 || $sub2==1100 || $sub2==1101 || $sub2==1110 || $sub2==1111 )
{
$smoke= '<font color="red">"Bus is on fire"</font>';
}
else
{
$smoke ="Your bus is safe";
}
//bit 9
if($sub2==10 || $sub2==11 || $sub2==110 || $sub2==111 || $sub2==1010 || $sub2==1011 || $sub2==1110 || $sub2==1111 )
{
$Seatbelt= '<font color="red">"Drivers seatbelt is Not worn"</font>';
}
else
{
$Seatbelt ="Driver's seatbelt is worn";
}
//bit8
if($sub2== 1 || $sub2== 11 || $sub2== 101|| $sub2== 111|| $sub2== 1001|| $sub2== 1011|| $sub2== 1101|| $sub2== 1111)
{
$SOS= '<font color="red">"SOS is pressed"</font>';
}
else
{
$SOS ="SOS is Not pressed";
}

print "<tr><th>Device ID</th><td>" . $row['uniqueid'] . "</td></tr>"; 
print "<tr><th>Device Name </th><td>" . $row['name'] . "</td></tr>"; 
print "<tr><th>Latitude</th><td>" . $row['latitude'] . "</td></tr>";
print "<tr><th>Longitude</th><td>" . $row['longitude'] . "</td></tr>";
print "<tr><th>Altitude</th><td>" . $row['altitude'] . "</td></tr>";
print "<tr><th>Speed Limit </th><td>" . $row['SpeedLimit'] . "</td></tr>";
print "<tr><th>speed</th><td>" . $row['speed'] . "</td></tr>";
print "<tr><th>Fuel Level</th><td>" .$fuellevel."%". "</td></tr>";
print "<tr><th>Oil Level</th><td>" . $oillevel. "%"."</td></tr>";
print "</table>"; 
echo '<table class="table table-striped">';
if($row['BusStatus'] =='Not Working Correctly')
{
echo "<strong><h3>Bus Status : " . $row['BusStatus']."</strong></h3>"; 
print "<tr><th>Speed </th><td>" . $SpeedErr. "</td></tr>";
print "<tr><th>Fuel Level </th><td>" . $fuelErr. "</td></tr>";
print "<tr><th>Oil Level </th><td>" . $oilErr. "</td></tr>";
print "<tr><th>Car Tires</th><td>" . trim($tireErr,'+'). "</td></tr>";
print "<tr><th>Maintenance Date </th><td>" . trim($maintenanceErr,'+'). "</td></tr>";
print "<tr><th>Engines' Temperatue </th><td>" . $temp. "</td></tr>";
print "<tr><th>Accident status </th><td>" . $accident. "</td></tr>";
print "<tr><th>Fire Status </th><td>" . $smoke. "</td></tr>";
print "<tr><th>Seatbelt status</th><td>" . $Seatbelt. "</td></tr>";
print "<tr><th>SOS button </th><td>" . $SOS. "</td></tr>";
}
}
}
print "</table>"; 


////
echo '<table class="table table-striped">';
 $sql="SELECT * 
  From drives , driver
  WHERE drives.DriverId = driver.DriverID AND drives.BusLicensePlate= '$LPL' ";
  $result =$db1->query($sql);
  if($result ==null)
{echo '<strong><h4>There is No drivers assigned for this bus in your fleet</strong></h4>';}
else{
echo "<h3><strong>Driver information</strong></h3>";
  while($row = $result->fetch_assoc()) 
{ 
print "<tr><th>Driver ID</th><td>" . $row['DriverID'] . "</td></tr>"; 
print "<tr><th>First Name </th><td>" . $row['FName'] . "</td></tr>"; 
print "<tr><th>Last Name </th><td>" . $row['LName'] . "</td></tr>";
print "<tr><th>Notes </th><td>" . $row['Notes'] . "</td></tr>";
print "<tr><th>Driving License No </th><td>" . $row['DrivingLicenseNo'] . "</td></tr>";
print "<tr><th>Driving License Expiry Date</th><td>" . $row['DrivingLicenseExpiryDate'] . "</td></tr>";
print "<tr><th>Phone No</th><td>" . $row['PhoneNo'] . "</td></tr>";
print "<tr><th>Shift</th><td>" . $row['Shift'] . "</td></tr>";
}
}
print "</table>"; 

?>
</div>
<div class="col-lg-3"></div>
</body>
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
                 <a href="busstatus.php"> <li>Bus status and reports </li>
                
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