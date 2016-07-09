<?php
error_reporting(E_ALL ^ E_DEPRECATED &~E_NOTICE);

 include("config.php");
if($_POST['id'])
{
	
$id=mysql_escape_String($_POST['id']);
$sl=mysql_escape_String($_POST['sl']);
$price=mysql_escape_String($_POST['price']);
$lp=mysql_escape_String($_POST['lp']);
$firstname=mysql_escape_String($_POST['firstname']);
$lastname=mysql_escape_String($_POST['lastname']); 

	
$sql = "update bus set 	TicketPrice='$price',SpeedLimit='$sl' where ID='$id'";
mysql_query($sql);

$sql2="select * from driver where FName='$firstname' and LName='$lastname'";
$query = mysql_query($sql2);
$sql4="select * from bus where ID='$id' ";
$query1 = mysql_query($sql4);

mysql_query($sql4);
if(mysql_num_rows($query)>0){

while($row=mysql_fetch_array($query)){$did=$row['DriverID'];}

while($row1=mysql_fetch_array($query1)){$busno=$row1['BusNo']; $lp=$row1['LicensePlate'];}
$sql3 = "update drives set 	DriverId='$did' where  BusLicensePlate='$lp' ";
if(!mysql_query($sql3)){die('Error :'.mysql_error());}		
mysql_query($sql3);

}
else{echo'THERE IS NO DRIVER WITH THIS NAME';}	

}
?>