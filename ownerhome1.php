 <?php

session_start();

error_reporting(E_ALL ^ E_DEPRECATED &~E_NOTICE);
require ('config.php');
$id=$_SESSION["id"]; 



echo 
'
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Vehicle Tracking Systtem</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
         <body>
<div class="row"> <div class="col-md-3"></div>         

<div class="col-md-6">
            <div class="panel panel-default " style="margin-top:100">
               <div class="panel-heading"   style="font-size:19"><b>Personal Information</div>';

$sql = "SELECT * FROM `grandcompanyowneraccount` where  FleetOwnerId='$id'";
$query = mysql_query($sql);
if(!mysql_query($sql)){die('Error :'.mysql_error());}					   

while($row = mysql_fetch_array($query))
{
    
    
     echo'
         <div class="table-responsive"><table class="table">
   
    
      <tr>
        <td><b>Name</td>
        <td>'. $row['FName'] ."  " . $row['LName'].'</td>
      
      </tr>
      <tr>
        <td><b>E-mail</td>
        <td>'. $row['Email'] .'</td>
   
      </tr>
      <tr>
        <td><b>Company </td>
        <td>'. $row['CompanyName'] .'</td>

      </tr>
       <tr>
        <td><b>Phone </td>
        <td>'. $row['OwnerPhoneNumber'] .'</td>

      </tr>
    
  </table></div>';
    
    
    
    
    
    
    
    
    
    //.......................................................
    

}
echo'             </div> </div>
    
<div class="col-md-3"></div>		 </body>	 
</html>';	 




?>