
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<html>
    <head>
        <img  src="images/gr.png" class="img-responsive"   style='position:fixed;top:0px;left:0px;width:100%;height:100%;z-index:-1;' >
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Vehicle Tracking Systtem</title>
	<link rel="stylesheet" href="ownerstyle.css" type="text/css">
	</head>
	<script type="text/javascript" src="http://ajax.googleapis.com/
ajax/libs/jquery/1.5/jquery.min.js"></script>
<div class="col-lg-3"></div>
<script type="text/javascript">
$(document).ready(function()
{
$("#flip").click(function(){
	$("#panel").slideToggle("slow");
});	
$("#flip1").click(function(){
	$("#panel1").slideToggle("slow");
});	
$(".edit_tr").click(function()
{
var ID=$(this).attr('id');
$("#sl_"+ID).hide();
$("#price_"+ID).hide();
$("#sl_input_"+ID).show();
$("#price_input_"+ID).show();
$("#first_"+ID).hide();
$("#last_"+ID).hide();
$("#first_input_"+ID).show();
$("#last_input_"+ID).show();

}).change(function()
{
var ID=$(this).attr('id');
var sl=$("#sl_input_"+ID).val();
var price=$("#price_input_"+ID).val();
var LP=$("span").attr('value');
var first=$("#first_input_"+ID).val();
var last=$("#last_input_"+ID).val();

//var LP=$("#lp_"+ID).val();
var dataString = 'id='+ ID +'&sl='+sl+'&price='+price + '&lp='+LP+'&firstname='+first+'&lastname='+last;
$("#sl_"+ID).html('<img src="load.gif" />'); // Loading image

if(sl.length>0&& price.length>0)
{


$.ajax({
type: "POST",
url: "ownerupdate_edit_ajax.php",
data: dataString,
cache: false,
success: function(html)
{
$("#sl_"+ID).html(sl);
$("#price_"+ID).html(price);
$("#first_"+ID).html(first);
$("#last_"+ID).html(last);
}
});
}
else
{
alert('Enter something.');
}

});

// Edit input box click action
$(".editbox").mouseup(function() 
{
return false
});

// Outside click action
$(document).mouseup(function()
{
$(".editbox").hide();
$(".text").show();
});
});
</script>
<style>
#panel, #flip ,#flip1, #panel1{
	color: black;
    padding: 5px;
    text-align: center;
    background-color: #f3f3f3;
    border: solid 1px #f3f3f3;
}

#panel, #panel1 {
    padding: 50px;
    display: none;
}
</style>
<div class="col-lg-6"style="margin-top: 50" align="right" >

         <body>
         	 <form name="own"  onsubmit="submitfn()"  method="post" >
<table class="table table-striped">
<tr>
          <th></th>
          <th>License Plate</th>
		  <th>Speed Limit</th>
		  <th> Price of ticket</th>
          <th colspan=2>Driver Name</th> 	       
          </tr>
<?php
include('config.php');
session_start();$companyname=$_SESSION["cname"];$username=$_SESSION["username"]; 
$sql=mysql_query("select * from bus where  CompanyName='$companyname' and OwnerUserName='$username'");
//$id=1;	
  if($sql ==null)
{echo '<h4><strong>There is No buses in your fleet</strong></h4>';}
else{
echo "<h3><strong>Bus details</strong></h3>";
while($row=mysql_fetch_array($sql))
{ 
$id=$row['ID'];
//while($id!=$dd)
//{ ini_set('max_execution_time', 300); $id++;}

//$busno=$row['BusNo'];   
$lp=$row['LicensePlate'];
$sl=$row['SpeedLimit'];
$price=$row['TicketPrice'];
?>
<tr id="<?php echo $id; ?>" class="edit_tr">
 
<td><input type="checkbox" name="removed[]" value= "<?php echo $lp; ?>"  ></td>
<td><span value="<?php echo $lp; ?>"><?php echo $lp; ?></span></td>

<td class="edit_td">
<span id="sl_<?php echo $id; ?>" class="text"><?php echo $sl; ?></span>
<input type="text" value="<?php echo $sl; ?>" class="editbox" id="sl_input_<?php echo $id; ?>" /&gt;
</td>

<td class="edit_td">
<span id="price_<?php echo $id; ?>" class="text"><?php echo $price; ?></span> 
<input type="text" value="<?php echo $price; ?>" class="editbox" id="price_input_<?php echo $id; ?>"/>
</td>
<?php $sql5=mysql_query("SELECT  * FROM drives INNER JOIN driver ON driver.DriverID=drives.DriverId where BusLicensePlate='$lp' ");
  if($sql5 ==null)
{echo '<h4><strong>There is No driver for this bus in your fleet</strong></h4>';}
else{
//echo "<h3><strong>Bus details</strong></h3>";


if(mysql_num_rows($sql5)>0){
while($row1=mysql_fetch_array($sql5))
{ $fname = $row1['FName'];
$lname=$row1['LName']; 
?>
<td class="edit_td">
<span id="first_<?php echo $id; ?>" class="text"><?php echo $fname; ?></span>
<input type="text" value="<?php echo $fname; ?>" class="editbox" id="first_input_<?php echo $id; ?>" /&gt;
</td>

<td class="edit_td">
<span id="last_<?php echo $id; ?>" class="text"><?php echo $lname; ?></span> 
<input type="text" value="<?php echo $lname; ?>" class="editbox" id="last_input_<?php echo $id; ?>"/>
</td>
<?php
//$id++;
}}else{
?>	
<td class="edit_td">
<span id="first_<?php echo $id; ?>" class="text">   </span>
<input type="text" value="" class="editbox" id="first_input_<?php echo $id; ?>" /&gt;
</td>

<td class="edit_td">
<span id="last_<?php echo $id; ?>" class="text"></span> 
<input type="text" value="" class="editbox" id="last_input_<?php echo $id; ?>"/>
</td>	

<?php	
}
}
}
}
?>
</table>
<button type="submit" value="Remove" name="submit" class="btn btn-danger ">Remove </button>
</form>
<div id="flip"><b>Click TO ADD NEW BUS</b></div>
<div id="panel"><?php   error_reporting(E_ALL ^ E_DEPRECATED &~E_NOTICE);
require ('config.php'); 
 echo'<style>select:required:invalid {
  color: #f3f3f3;
}
option[value=""][disabled] {
  display: none;
}
option {
  color: black;
}</style>
     <form method="post"  action="ownerhomeupdate.php">   
     <input type="text" id="LicensePlate" name="LicensePlate" placeholder="LicensePlate" step="1" required class="form-control">
	 <input type="number" name="price"  placeholder="Ticket Price" step="1" required class="form-control"> 
     <input type="number" name="bno" placeholder="Bus Number" step="1" required class="form-control">
     <input type="text" name="bline" placeholder="Bus Line"  step="1" required class="form-control">
	 <select required size="1" name="D2"  class="form-control"                        
      <option>--</option><option value="" disabled selected hidden>  Geofence Id</option> ';
	 $sqlgeo = "SELECT * FROM `geofence` where CompanyName='$companyname'  and UserName='$username'  ";
     $querygeo = mysql_query($sqlgeo);
     while($rowgeo = mysql_fetch_array($querygeo))
     {	$gid=$rowgeo['GeofenceId'];         
        echo "<option>$gid</option> " ;
     }   
	 echo' </select>
	 <select required size="1" name="D3"  class="form-control"                        
      <option>--</option><option value="" disabled selected hidden > Geofence Name</option> ';
	 $sqlgn = "SELECT * FROM `geofence`where CompanyName='$companyname'  and UserName='$username' ";
     $querygn = mysql_query($sqlgn);
     while($rowgn = mysql_fetch_array($querygn))
     {	$gn=$rowgn['GeofenceName'];         
        echo "<option>$gn</option> " ;
     }    
	  
	 echo' </select>
     <input type="number" name="speedlimit" placeholder="Speed Limit" step="1" required class="form-control">
	 <input type="number" name="device" placeholder="Device Serial"  step="1" required class="form-control">
	 <select required size="1" name="D4" class="form-control"                         
          <option>--</option><option value="" disabled selected hidden> Driver Name</option> 	 ';
     $sqldn = "SELECT * FROM `driver` ";
     $querydn = mysql_query($sqldn);
     while($rowdn = mysql_fetch_array($querydn))
     {	$driverfname=$rowdn['FName'];         
        $driverlname=$rowdn['LName']; 
		//$driverid==$rowdn['DriverID'];
        echo "<option> $driverfname $driverlname</option> " ;
     }                           
 
     echo '  </select>
     <select required size="1" name="D1"   class="form-control"                       
          <option>--</option><option value="" disabled selected hidden> Bus Yard Name</option> 	 ';
     $sql = "SELECT * FROM `busyard` ";
     $query = mysql_query($sql);
     while($row = mysql_fetch_array($query))
     {	$busyard=$row['Name'];         
        echo "<option>$busyard</option> " ;
     }                           
 
     echo '  </select><br>
   	 <input  type="submit" name="submit1" value="ADD" class="btn btn-danger"><br>  
                        </form>
	
						
						'; 
     if(!isset($_POST['submit1']))
       {  }
      else{
		   if(isset($_POST['LicensePlate']))
            {
			    if (empty($_POST['D1'])) 
                   {
	   
                   }
                else
                {
                		 if (empty($_POST['D2'])){}else {		
                                if (empty($_POST['D3'])){}else{ 
                                          if (empty($_POST['D4'])){}else
										                            { 								
              // $busid = $_POST['LicensePlate'];
     	       $LicensePlate=$_POST['LicensePlate'];
		       $price=$_POST['price'];
               $bno=$_POST['bno'];
		       $bline=$_POST['bline'];
		       $gid=filter_input(INPUT_POST, 'D2');
		       $gname= filter_input(INPUT_POST, 'D3');
		       $speedlimit=$_POST['speedlimit'];
		       $busyard = filter_input(INPUT_POST, 'D1');
			   $device=$_POST['device'];
			   $drivername=filter_input(INPUT_POST, 'D4'); 
		       $sql = "SELECT * FROM `bus` where LicensePlate='$LicensePlate' or DeviceSerial='$device' ";
               $query = mysql_query($sql);
               if(!mysql_query($sql)){die('Error :'.mysql_error());}  
               if(mysql_num_rows($query)>0){echo'This Bus already exists';}
               else{
				       /* $sqlcheck="SELECT * FROM `subaccount` where PW='$pwd'";
					   $querycheck = mysql_query($sqlcheck);
					   if(mysql_num_rows($querycheck)>0){echo 'Change your Password to be unique';}
                       else{	 */	
                        $driverflname = explode(" ", $drivername);
                        $sqlget="SELECT * FROM `driver` where FName	='$driverflname[0]' and LName='$driverflname[1]'";
					    $queryget = mysql_query($sqlget);
 		                    while($rowget = mysql_fetch_array($queryget))
                                  {	
							           $driverid=$rowget['DriverID'];         
                                  } 				
			            $sql1 = "INSERT INTO `bus`(`LicensePlate`, `TicketPrice`, `GeofenceId`, `GeofenceName`, `SpeedLimit`,`BusCompanyName`,`GrandCompanyName`, `OwnerUserName`,  `DeviceSerial`) 
				          VALUES ('$LicensePlate','$price','$gid','$gname','$speedlimit','Green','$companyname','$username','$busyard','$device')  ";
                        
						//$sql1="INSERT INTO `customer_side_db`.`bus` (`LicensePlate`, `BusNo`, `BusLine`, `BusCompanyName`, `GeofenceId`, `GeofenceName`, `Speed`, `SpeedLimit`, `GrandCompanyName`, `OwnerUserName`, `TireLastChangeDate`, `KmLeftForNextTireChange`, `LastMaintenceDate`, `Distance`, `BusStatus`, `FuelLevel`, `FuelCapacity`, `DeviceSerial`, `SimPhoneNo`, `CurrentLatitude`, `CurrentLongtitude`, `CurrentLocationTime`, `DeviceInstallationTime`, `DeviceResetTime`, `BusYardName`, `TicketPrice`) VALUES 
						//( '$LicensePlate', '$bno', '$bline', 'Green', '12', 'goename', '76', '687', 'El Sakr', 'sakr', '', '', '', '', '', '', '', '4365468', '678789789', '', '', '', '', '', 'arab', '6');";
						$sqlbusyard="INSERT INTO `busyard`(`BusyardName`) VALUES ($busyard)";
						$querybusyard = mysql_query($sqlbusyard);
                        if(!mysql_query($sqlbusyard)){die('Error :'.mysql_error());}
						
						
						$query1 = mysql_query($sql1);
                        if(!mysql_query($sql1)){die('Error :'.mysql_error());}
						$sqldriver="INSERT INTO `drives`(`DriverID`,  `LicensePlate`) VALUES ('$driverid','$LicensePlate')";
						$querydriver = mysql_query($sqldriver);
                        if(!mysql_query($sqldriver)){die('Error :'.mysql_error());}
                        
					     //  }						
							  } 		
										                            }
																}
												        }
				}
		    }     
	   } 
	  // $sec = "10";
	 //  header("Refresh: $sec; url=$page");
	   ?></div>
<br>
	   <div id="flip1"><b>Click TO ADD NEW Yard</b></div>
       <div id="panel1"> <?php
         error_reporting(E_ALL ^ E_DEPRECATED &~E_NOTICE);
        require ('config.php'); 
 echo'<style>select:required:invalid {
  color: #999;
}
option[value=""][disabled] {
  display: none;
}
option {
  color: black;
}</style>
     <form method="post"  action="ownerhomeupdate.php">   
     <input type="text" id="name" name="name" placeholder="Name" step="1" required class="form-control">
	 <input type="number" name="num"  placeholder="Number Of Buses" step="1" required class="form-control"> 
     <input type="submit" name="submit2" value="ADD" class="btn btn-danger"><br>  
                        </form>
	 ';
	 if(!isset($_POST['submit2']))
       {  }
      else{
		   if(isset($_POST['name']))
            {
			$name=$_POST['name'];
		    $num=$_POST['num'];	
			$sqlcheck="SELECT * FROM `busyard` where Name='$name'";
					   $querycheck = mysql_query($sqlcheck);
					   if(mysql_num_rows($querycheck)>0){echo 'this yard already exists';}
                       else{
			
			$sqlin="INSERT INTO `busyard`(`Name`, `NumberOfBuses`) VALUES ('$name','$num')";
            $queryin = mysql_query($sqlin);
            if(!mysql_query($sqlin)){die('Error :'.mysql_error());}
					   }
			}
	  }
      ?></div>	   
<?php
error_reporting(E_ALL ^ E_DEPRECATED &~E_NOTICE);
require ('config.php'); 

if (isset($_POST['submit']))
{
if (empty($_POST['removed'])) 
{     
	
}
else
    { 	
	    foreach($_POST['removed'] as $selected) {
		$sql5="DELETE FROM `drives` WHERE `LicensePlate` = '$selected' ";	
		$query5=mysql_query($sql5);
		if(!mysql_query($sql5)){die('Error :'.mysql_error());}
		$sql4 = "DELETE FROM `stops` WHERE LicensePlate= '$selected' ";
        $query4 = mysql_query($sql4);
        if(!mysql_query($sql4)){die('Error :'.mysql_error());}
		$sql3 = "DELETE FROM `bus` WHERE `LicensePlate` = '$selected' and GrandCompanyName='$companyname' and OwnerUserName='$username' ";
        $query3 = mysql_query($sql3);
        if(!mysql_query($sql3)){die('Error :'.mysql_error());}
       			
		
				
	                                             }              
	}
//header ('Location: ' . $_SERVER['REQUEST_URI']);
 //   exit();
}



?>
           
      </div>     <div class="col-lg-3"></div>
</body></html>


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