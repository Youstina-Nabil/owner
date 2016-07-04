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
require ('config.php');
$counter = $_GET["ID"];
$LP = $_GET["LicensePlate"];
//echo $counter;
$LPL=rtrim($LP," </td");
//echo $LPL ."<br>";

$sqllink= ("SELECT * From Bus WHERE ID=$counter");
$resultlink = mysql_query($sqllink);
  if($resultlink ==null)
{echo '<h4><strong>There is No buses in your fleet</strong></h4>';}
else{
echo "<h3><strong>Bus details</strong></h3>";
while($row = mysql_fetch_array($resultlink, MYSQL_ASSOC)) 
{ 
print "<tr><th>License Plate </th><td>" . $row['LicensePlate'] . "</td></tr>"; 
//print "<tr><th>Bus No </th><td>" . $row['BusNo'] . "</td></tr>"; 
//print "<tr><th>Bus Line </th><td>" . $row['BusLine'] . "</td></tr>"; 
//print "<tr><th>Geofence Name </th><td>" . $row['GeofenceName'] . "</td></tr>";
//print "<tr><th>Speed </th><td>" . $row['Speed'] . "</td></tr>";
print "<tr><th>Speed Limit </th><td>" . $row['SpeedLimit'] . "</td></tr>";
print "<tr><th>Tire Last Change Date </th><td>" . $row['TireLastChangeDate'] . "</td></tr>";
print "<tr><th>Last Maintence Date </th><td>" . $row['LastMaintenanceDate'] . "</td></tr>";
print "<tr><th>Bus Status </th><td>" . $row['BusStatus'] . "</td></tr>";
print "<tr><th>Fuel Level </th><td>" . $row['FuelLevel'] . "</td></tr>";
print "<tr><th>Device Serial </th><td>" . $row['DeviceUniqueId'] . "</td></tr>";
print "<tr><th>Sim Phone No </th><td>" . $row['SimPhoneNo'] . "</td></tr>";
//print "<tr><th>Latitude </th><td>" . $row['CurrentLatitude'] . "</td></tr>";
//print "<tr><th>Longtitude </th><td>" . $row['CurrentLongtitude'] . "</td></tr>";
//print "<tr><th>Current Location Time </th><td>" . $row['CurrentLocationTime'] . "</td></tr>";
print "<tr><th>Device Installation Time </th><td>" . $row['DeviceInstallationTime'] . "</td></tr>";
print "<tr><th>Device Reset Time </th><td>" . $row['DeviceResetTime'] . "</td></tr>";
//print "<tr><th>Bus Yard Name  </th><td>" . $row['BusYardName'] . "</td></tr>";
} 
}
print "</table>";

echo '<table class="table table-striped">';
 $sql="SELECT * 
  From drives , driver
  WHERE drives.DriverId = driver.DriverID AND drives.BusLicensePlate= '$LPL' ";
  $result = mysql_query($sql);
  if($result ==null)
{echo '<strong><h4>There is No drivers assigned for this bus in your fleet</strong></h4>';}
else{
echo "<h3><strong>Driver information</strong></h3>";
  while($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
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