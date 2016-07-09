<?php
session_start();
?>
<!DOCTYPE html>
<html>

    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Vehicle Tracking Systtem</title>
	
	<link rel="stylesheet" href="style.css" type="text/css">
	</head>
	<body>
<div id="wrapper">
<table id="keywords" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th><span> Fleet owner </span></th>
        <th><span> Company </span></th>
        
        <th><span>Account type</span></th>
        <th><span>Number of buses</span></th>
      </tr>
    </thead>
    <tbody>
    	  	   
    


<?php
error_reporting(E_ALL ^ E_DEPRECATED &~E_NOTICE);

  $db1 = new mysqli('localhost','root','','serviceprovider_db');
  $db2 = new mysqli('localhost','root','','device_database');
  $db3 = new mysqli('localhost','root','','customer_side_db');
if ($db1->connect_error) {
    die("Connection failed: " . $db1->connect_error);
} 
if ($db2->connect_error) {
    die("Connection failed: " . $db2->connect_error);
}
if ($db3->connect_error) {
    die("Connection failed: " . $db3->connect_error);
}

   
$sql = "SELECT * FROM `customer` ";
        $query  = $db1->query($sql);
	$sqljoin="SELECT * 
  From device_database.users INNER JOIN serviceprovider_db.customer 
  ON device_database.users.email= serviceprovider_db.customer.Email
  where serviceprovider_db.customer.Approved='1' ";
  
  $resultjoin =($db1->query($sqljoin) ) AND ($db2->query($sqljoin));
while($row2 = $query->fetch_assoc())
{
$ap=$row2['Approved'];
if($ap==1){	
//WHERE device_database.user_device.userid=device_database.users.id";
// INNER JOIN device_database.users 
//  ON device_database.user_device.userid= device_database.users.id

  if($resultjoin == null  )
  {echo "empty";}
else{
while($row =$resultjoin->fetch_assoc())
{
$id=$row["id"];
$sqlup =("SELECT COUNT(*) as devices FROM user_device WHERE userid=$id " );
$queryup =$db2->query($sqlup);
$data=$queryup->fetch_assoc();
$buses= $data['devices'];
//echo $buses;
echo "<tr>";
echo '<td class="lalign">' . $row['FName']  ."  " . $row['LName'] ."</td>";
echo "<td>" . $row['CompanyName'] . "</td>";
echo "<td>" . $row['AccountName'] . "</td>";
echo '<td>
      <form name="f1" action="adminedit.php" >
      <button name="change" type="submit" value="change">' . $buses . "</button>
                </form>
                <td>				
				";
echo "</tr>";
}}
}
}
?>

</tbody>
  </table>
   </div>
  <br><br>
   
   
    <div id="wrapper">
<table id="keywords" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th><span> Fleet owner </span></th>
        <th><span> Company </span></th>
        
        <th><span>Account type</span></th>
        <th><span> Approve </span></th>
      </tr>
    </thead>
    <tbody>
   
<?php	
$sql1 = "SELECT * FROM `customer` ";
        $query1  = $db1->query($sql1);
        $sqljoin2="SELECT * 
  From device_database.users INNER JOIN serviceprovider_db.customer 
  ON device_database.users.email= serviceprovider_db.customer.Email

  where serviceprovider_db.customer.Approved='0' ";
  //AND device_database.users.name= serviceprovider_db.customer.CompanyName
  $resultjoin2 =($db1->query($sqljoin2) ) AND ($db2->query($sqljoin2));
         if($query1 == null  )
  {echo "empty";}
else{
while($row3 = $query1->fetch_assoc())
{
$ap=$row3['Approved'];
if($ap==0){	
//  INNER JOIN device_database.users 
 // ON device_database.user_device.userid= device_database.users.id

  if($resultjoin2 == null  )
  {echo "empty";}
  else{
while($row1 =$resultjoin2->fetch_assoc())
{
$id2=$row1["id"];
$sqlup =("SELECT COUNT(*) as devices FROM user_device WHERE userid=$id2 " );
$queryup =$db2->query($sqlup);
$data=$queryup->fetch_assoc();
$buses= $data['devices'];
	$fname =$row1['FName'];
	$lname= $row1['LName'];
	$cname= $row1['CompanyName'];
	$ID=$row1['CustomerID'];
	$username=$row1['Username'];
	$email=$row1['Email'];
	$pw=$row1['PW'];
	$phone=$row1['PhoneNumer'];
	//echo$buses;
	$maxbus=$row1['MaxNoOfBuses'];
	$subacc=$row1['NoOfSubAccounts'];
	$accp=$row1['AccountPrice'];
	echo "<tr>";
echo '<td class="lalign">' . $row1['FName']  ."  " . $row1['LName'] ."</td>";
echo "<td>" . $row1['CompanyName'] . "</td>";
echo "<td>" . $row1['AccountName'] . "</td>";
echo '<td>
      <form  action="adminy.php" onsubmit="submitfn()"  method="post">
	        <button type="submit" value="Approve" name="submit" > Approve </button>
      </form>
      <td>				
				';
echo "</tr>";

 
if (isset($_POST['submit']) && isset($_SERVER['REQUEST_URI']) )
{ 
$sql1 = ("UPDATE customer SET 	Approved = 1 WHERE CustomerID = $ID " );
$query1  = $db1->query($sql1);

$sql2 = ("INSERT INTO fleetowner (FName,LName,CompanyName,FleetOwnerId,UserName,Email,PW,OwnerPhoneNumber,NoOfBuses,MaxNoOfBuses,NoOfSubAccounts, AccPrice)
 VALUES ('$fname','$lname','$cname','$ID','$username','$email','$pw','$phone','$buses','$maxbus','$subacc','$accp') ");
$query2  = $db3->query($sql2);
exit();
//$_SESSION["customerid"] = $ID;
}
		}
}}
}}

?>		
</tbody>
  </table>
   </div>