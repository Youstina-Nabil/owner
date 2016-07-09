<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <title>Edit your fleet</title>
  
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <style>
            .navbar {
      margin-bottom: 0;
      background-color: #e4e4e4;
      z-index: 9999;
      border: 0;
      font-size: 12px !important;
      line-height: 1 !important;
      letter-spacing: 4px;
      border-radius: 0;
      font-family: Montserrat, sans-serif;
      height:40px;
      
  }
  .navbar li a, .navbar .navbar-brand {
      color: black !important;
  }
  .navbar-nav li a:hover, .navbar-nav li.active a {
      color:black !important;
      background-color: #fff !important;
  }
  .navbar-default .navbar-toggle {
      border-color: transparent;
      color: black !important;
  }
            
        </style>    
</head>

<body>
                    <div>
                        <nav class="navbar navbar-default navbar-fixed-top">
               <div class="container">
                 <div class="navbar-header">
                   <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                   </button>
                   <a class="navbar-brand" href="#myPage" style="font-size:1em">Vehicle Tracking System</a>
                 </div>
                 <div class="collapse navbar-collapse" id="myNavbar">
                   <ul class="nav navbar-nav navbar-right">
                     <li><a href="home.php">Home</a></li>
                     <li><a href="adminsh.php">Account</a></li>
                     <li><a href="home.php#about">About us</a></li>
                     <li><a href="contact.php">CONTACT</a></li>
                   </ul>
                 </div>
               </div>
             </nav>
                </div>
    
    
    <div class="container-fluid" style="margin-top: 100px">
        
        <div class="container">
    <div class="container text-center">
        <h2 style="margin:auto">Edit your fleet</h2>
        <p><br></p>
    </div>
  
  <div class="panel-group">
      <div class="row">
          
          <div class="col-lg-6">
              <div class="panel panel-default" id="add">
      <div class="panel-heading">Add new bus</div>
      <div class="panel-body">
        <link rel="stylesheet" href="style.css">

            
        <h3> You can add new buses from here </h3>

<form method="post" name ="add" id="Fadd" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">   
<input type="hidden" name="custID"  value="<?php echo $_REQUEST['custID'] ;?> " >
  Device Serial: <input type="number" name="deviceSerial"  step="1" required>
 
  <br><br>
    SIMPCARD Number: <input type="number" name="SIMPhoneNumber"  step="1" required >
  
  <br><br>
  <input type="submit" name="addsubmit" value="Submit">  
</form>

  
      
      </div>
    </div>
              
          </div>
          
          <div class="col-lg-6">
              <div class="panel panel-default" id="remove">
      <div class="panel-heading">Remove bus</div>
      <div class="panel-body">




          <h3> You can remove buses from here  </h3>
     
<form method="post" name="remove" id="Fremove" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<input type="hidden" name="custID"  value="<?php echo $_REQUEST['custID'] ;?> " >
  Device Serial: <input type="number" name="deviceSerial"  step="1" required>
    
  <br><br>
  <input type="submit" name="removesubmit" value="Submit">  
</form>

     
      
      
      </div>
    </div>
              
          </div>
          
          
      </div>
    
        
    
  </div>
</div>
        
        
    </div>
       

</body>
  
<?php

error_reporting(E_ALL ^ E_DEPRECATED &~E_NOTICE);
error_reporting(E_ALL ^ E_NOTICE);

					   require ('config2.php');
					

    	 $SIMErr = $deviceSerialErr =  "";
         $SIM= $deviceSerial =  "";
         
         if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            if (empty($_POST["deviceSerial"])) {
               $deviceSerialErr = "Device Serial is required";
            }else {
               $deviceSerial = test_input($_POST["deviceSerial"]);
            }
            
            if (empty($_POST["SIMPhoneNumber"])) {
                $SIMErr = "SIMPCARD Number is required";
            }else {
               $SIM = test_input($_POST["SIMPhoneNumber"]);
            }
          
         }
          function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
         }
         ?>

<?php 


//$custID="2124234";
$custID =$_REQUEST['custID'];
if (!empty($_POST['addsubmit'])) {
//check if this data is duplicated
$sqlup=( "SELECT * FROM device WHERE SIMPhoneNumber=$SIM  OR DeviceSerial=$deviceSerial  ");
$resultup = mysql_query($sqlup);
$num_rows = mysql_num_rows($resultup);
//echo $num_rows;
if ($num_rows > 0  ){
echo'<P><strong>There exists device with this serial number or with the same SIM phone number</strong><P>';
}
else{

$sql=("SELECT NoOfBuses FROM customer WHERE CustomerID=$custID and (NoOfBuses+1) < MaxNoOfBuses");
$result = mysql_query($sql);
$num_rows = mysql_num_rows($result);
//echo $num_rows;
if ($num_rows == 1 ){
//echo "hi";
$sqladd = ("INSERT INTO device (DeviceSerial,SIMPhoneNumber,CustomerID) VALUES ( $deviceSerial,$SIM,$custID) ");
$sqladd1 = ("UPDATE customer SET NoOfBuses =(NoOfBuses+1) WHERE CustomerID = $custID " );
$resultadd = mysql_query($sqladd);
$resultadd1 = mysql_query($sqladd1);
echo'<P><strong> New bus is added</strong><P>'."</br>";

}
else{echo'<P><strong> You can NOT add more buses</strong><P>';}
}
}


if (!empty($_POST['removesubmit'])) {

$sql2=( "SELECT * FROM device WHERE CustomerID=$custID  AND DeviceSerial=$deviceSerial  ");
$result = mysql_query($sql2);
$num_rows = mysql_num_rows($result);
//echo $num_rows;
if ($num_rows == 0  ){
echo'<P><strong> There is No device with this serial number</strong><P>';
}
else{
$sqlremove = ("DELETE FROM device WHERE CustomerID =$custID AND DeviceSerial =$deviceSerial ");
$sqlremove1 = ("UPDATE customer SET 	NoOfBuses =(NoOfBuses-1)  WHERE CustomerID = $custID " );
$resultremove = mysql_query($sqlremove);
$resultremove1 = mysql_query($sqlremove1);
echo '<P><strong> Bus is deleted</strong><P>'."</br>";
}
}
?>


    
    

</html>

