
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
$("#flip2").click(function(){
	$("#panel2").slideToggle("slow");
});
$("#flip3").click(function(){
	$("#panel3").slideToggle("slow");
});
$("#flip4").click(function(){
	$("#panel4").slideToggle("slow");
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
#panel, #flip ,#flip1, #panel1,#flip2, #panel2,#flip3, #panel3,#flip4, #panel4{
	color: black;
    padding: 5px;
    text-align: center;
    background-color: #f3f3f3;
    border: solid 1px #f3f3f3;
}

#panel, #panel1,#panel2,#panel3,#panel4{
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
		  <th>Bus Number</th>
          <th>License Plate</th>
           <th>device Password</th>
		  <th>Speed Limit</th>
		  <th> Price of ticket</th>
          <th colspan=2>Driver Name</th> 	       
          </tr>
<?php
include('config.php');
session_start();$companyname=$_SESSION["cname"];$username=$_SESSION["username"]; $custid=$_SESSION["id"];
$sql=mysql_query("select * from bus where  CompanyName='$companyname' and OwnerUserName='$username'");
//change here
while($row=mysql_fetch_array($sql))
{ 
$id=$row['ID'];
$lp=$row['LicensePlate'];
$sqlbn=mysql_query("select * from belongs_to where BusLicensePlate='$lp' ");if(!mysql_query("select * from belongs_to where BusLicensePlate='$lp' ")){die('Error :'.mysql_error());} while($rowbn=mysql_fetch_array($sqlbn)){$busno=$rowbn['BusNo']; }

$sl=$row['SpeedLimit'];
$price=$row['TicketPrice'];
?>
<tr id="<?php echo $id; ?>" class="edit_tr">
 
<td><input type="checkbox" name="removed[]" value= "<?php echo $lp; ?>"  ></td>
<td><?php echo $busno; ?></td>
<td><span value="<?php echo $lp; ?>"><?php echo $lp; ?></span></td>

<td class="edit_td">
<span id="sl_<?php echo $id; ?>" class="text"><?php echo $sl; ?></span>
<input type="text" value="<?php echo $sl; ?>" class="editbox" id="sl_input_<?php echo $id; ?>" /&gt;
</td>

<td class="edit_td">
<span id="price_<?php echo $id; ?>" class="text"><?php echo $price; ?></span> 
<input type="text" value="<?php echo $price; ?>" class="editbox" id="price_input_<?php echo $id; ?>"/>
</td>
<?php $sql5=mysql_query("SELECT  * FROM drives INNER JOIN driver ON driver.DriverID=drives.DriverID where BusLicensePlate='$lp' ");
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
?>
</table>
<button type="submit" value="Remove" name="submit" class="btn btn-danger ">Remove </button>
</form>
<div id="flip"><b>Click TO ADD NEW BUS</b></div>
<div id="panel"><?php   error_reporting(E_ALL ^ E_DEPRECATED &~E_NOTICE);
$dbh1 = mysql_connect("localhost", "root", ""); 
$dbh2 = mysql_connect("localhost", "root", "", true); 
mysql_select_db('serviceprovider_db', $dbh2);
mysql_select_db('customer_side_db', $dbh1);

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
     <input type="number" name="speedlimit" placeholder="Speed Limit" step="1" required class="form-control">
	 <input type="number" name="bustype" placeholder="Bus Type"  step="1" required class="form-control">
         <input type="number" name="bustype" placeholder="Device password"  step="1" required class="form-control">
	 <select required size="1" name="device" class="form-control"                         
     <option>--</option><option value="" disabled selected hidden> Device Unique Id->SIMCardNumber</option> ';
    
		$sql_="SELECT  * from device where 	CustomerID='$custid' ";
		$query_=mysql_query($sql_,$dbh2);
        while ($row_ = mysql_fetch_array($query_))
		{
			$simcard=$row_['SIMPhoneNumber'];
			$deviceid= $row_['DeviceUniqueID'];
            $sqlcheckdevice="select LicensePlate from bus where DeviceUniqueID='$deviceid'"; 
			 $querycheckdevice = mysql_query($sqlcheckdevice,$dbh1);
			if(!mysql_query($sqlcheckdevice,$dbh1)){die('Error :'.mysql_error());} 
			 if(mysql_num_rows($querycheckdevice)>0){}else{ echo "<option>$deviceid->$simcard</option> " ; } 
		}
	 
	 
	 echo'</select>
	 	 <br>
   	 <input  type="submit" name="submit1" value="ADD" class="btn btn-danger"><br>  
                        </form>
	
						
						'; 
     if(!isset($_POST['submit1']))
       {  }
      else{
		   if(isset($_POST['LicensePlate']))
            {
			    if (empty($_POST['device'])) 
                   {
	   
                   }
                else
                {
                		 if (empty($_POST['bustype'])){}else {		
                                if (empty($_POST['price'])){}else{ 
                                          if (empty($_POST['speedlimit'])){}else
										                            { 								
              // $busid = $_POST['LicensePlate'];
     	       $LicensePlate=$_POST['LicensePlate'];
		       $price=$_POST['price'];
		       $speedlimit=$_POST['speedlimit'];
               $device=filter_input(INPUT_POST, 'device');list($unid, $phone) = explode("->", $device);echo $unid;
		       $sql = "SELECT * FROM `bus` where LicensePlate='$LicensePlate' or DeviceUniqueId='$unid' ";
               $query = mysql_query($sql,$dbh1);
               if(!mysql_query($sql,$dbh1)){die('Error :'.mysql_error());}  
               if(mysql_num_rows($query)>0){echo'This Bus already exists';}
               else{
				       
                       	
			            $sql1 = "INSERT INTO `bus`(`LicensePlate`, `TicketPrice`, `SpeedLimit`,`CompanyName`, `OwnerUserName` ,`DeviceUniqueId`,`SimPhoneNo`) 
				          VALUES ('$LicensePlate','$price','$speedlimit','$companyname','$username','$unid','$phone')  ";
						  if(!mysql_query($sql1,$dbh1)){die('Error :'.mysql_error());}
						$query1 = mysql_query($sql1,$dbh1);
						
							  } 		
										                            }
																}
												        }
				}
		    }     
	   } 

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
     <input type="submit" name="submit2" value="ADD" class="btn btn-danger"><br>  
                        </form>
	 ';
	 if(!isset($_POST['submit2']))
       {  }
      else{
		   if(isset($_POST['name']))
            {
			$name=$_POST['name'];
			$sqlcheck="SELECT * FROM `busyard` where BusyardName='$name'";
					   $querycheck = mysql_query($sqlcheck);
					   if(mysql_num_rows($querycheck)>0){echo 'this yard already exists';}
                       else{
			
			$sqlin="INSERT INTO `busyard`(`BusyardName`) VALUES ('$name')";
            $queryin = mysql_query($sqlin);
            if(!mysql_query($sqlin)){die('Error :'.mysql_error());}
					   }
			}
	  }
      ?></div>	   
	  <br>
	   <div id="flip2"><b>Click TO ADD NEW Line</b></div>
       <div id="panel2"> <?php
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
     <input type="text" id="name" name="name" placeholder="Bus Line Name" step="1" required class="form-control">
	 <input type="text" id="num" name="num" placeholder="Bus Number" step="1" required class="form-control">
     <input type="submit" name="submit3"  value="ADD" class="btn btn-danger"><br>  
                        </form>
	 ';
	 if(!isset($_POST['submit3']))
       {  }
      else{
		   if(isset($_POST['name']))
            {
				if(isset($_POST['num']))
                {
			     $num=$_POST['num'];		
			     $name=$_POST['name'];
			     $sqlbl="SELECT * FROM `busline` where BusLineName='$name'";
					   $querybl = mysql_query($sqlbl);
					   if(mysql_num_rows($querybl)>0){/*echo 'this line already exists';*/}
                       else{
			     $sqlbl1="INSERT INTO `busline`(`BusLineName`,`BusNo`,`CompanyName`, `OwnerUserName`) VALUES ('$name','$num','$companyname','$username')";
                 $querybl1 = mysql_query($sqlbl1);
                 if(!mysql_query($sqlbl1)){/*die('Error :'.mysql_error());*/} //mysql_free_result($querybl1);   
						 //  header("Location:draw.php"); 
						   
						   }
				}
			}
	  }
      ?></div><br>
	   <div id="flip4"><b>Draw Geofence For Bus Line</b></div>
       <div id="panel4"> <?php
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
     <form method="post"  action="draw.php">   
<select required size="1" name="buslineno"                          
          <option>--</option><option value="" disabled selected hidden> Bus Line & Number</option>'; 	
		  $sqlno = "SELECT * FROM `busline` where CompanyName='$companyname' and OwnerUserName='$username' ";
          $queryno = mysql_query($sqlno);
          while($rowno = mysql_fetch_array($queryno))
          {	$busline=$rowno['BusLineName'];
	       $busno=$rowno['BusNo'];
		   echo "<option>$busline->$busno</option> " ;
          }   
		  
		  
	 echo ' 
     	  </select>	  
     <input type="submit" name="submit5"  value="GO" class="btn btn-danger"><br>  
                        </form>
	 ';
	 if(!isset($_POST['submit5']))
       {  }
      else{
		   if(isset($_POST['buslineno']))
            {
			    $num=filter_input(INPUT_POST, 'buslineno');
				$num1 = explode("->", $num);
                       
			     
					        $_SESSION["Redraw_Bus_line_name"] = $num1[0];  $_SESSION["Redraw_Bus_No"] = $num1[1]; 
						 //  echo $num1[0];
						   
				
			}
	  }
      ?></div><br> 
	  
<div id="flip3"><b>Assigne Line to bus</b></div>
       <div id="panel3"> <?php
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
          <select required size="1" name="license"                          
          <option>--</option><option value="" disabled selected hidden> License Plate</option> 	';
		  
		  $sqllp = "SELECT * FROM `bus` where CompanyName='$companyname' and OwnerUserName='$username' ";
          $querylp = mysql_query($sqllp);
          while($rowlp = mysql_fetch_array($querylp))
          {	
	       $license=$rowlp['LicensePlate'];
          /*  $sqlcheck="SELECT * FROM `belongs_to` WHERE `BusLicensePlate`='$license'";
           $querycheck = mysql_query($sqlcheck);
           if(mysql_num_rows($querycheck)<=0)
	    	{ */
			echo "<option> $license</option> " ;
	    	//}
          }                              
     echo ' 
     	  </select>
          <select required size="1" name="no"                          
          <option>--</option><option value="" disabled selected hidden> Bus Line & Number</option>'; 	
		  $sqlno = "SELECT * FROM `busline` where CompanyName='$companyname' and OwnerUserName='$username' ";
          $queryno = mysql_query($sqlno);
          while($rowno = mysql_fetch_array($queryno))
          {	$busline=$rowno['BusLineName'];
	       $busno=$rowno['BusNo'];
		   echo "<option>$busline $busno</option> " ;
          }   
		  
		  
	 echo ' 
     	  </select>	  
		  
	<input type="submit" name="submit4" value="ADD" class="btn btn-danger"><br>  
                        </form>
	 ';
	 if(!isset($_POST['submit4']))
       {  }
      else{
		   if(isset($_POST['license']))
            {
				if(isset($_POST['no']))
                {			
			    $license=filter_input(INPUT_POST, 'license');
			    $num=filter_input(INPUT_POST, 'no');
				$num1 = explode(" ", $num);
			    $sqlbl1="INSERT INTO `belongs_to`(`BusLineName`, `BusNo`, `BusLicensePlate`) VALUES ('$num1[0]','$num1[1]','$license')";
                $querybl1 = mysql_query($sqlbl1);
               // if(!mysql_query($sqlbl1)){die('Error :'.mysql_error());}
					       
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
		$sql5="DELETE FROM `drives` WHERE `BusLicensePlate` = '$selected' ";	
		$query5=mysql_query($sql5);
		if(!mysql_query($sql5)){die('Error :'.mysql_error());}
		$sql4 = "DELETE FROM `belongs_to` WHERE BusLicensePlate= '$selected' ";
        $query4 = mysql_query($sql4);
        if(!mysql_query($sql4)){die('Error :'.mysql_error());}
		$sql3 = "DELETE FROM `bus` WHERE `LicensePlate` = '$selected' and CompanyName='$companyname' and OwnerUserName='$username' ";
        $query3 = mysql_query($sql3);
        if(!mysql_query($sql3)){die('Error :'.mysql_error());}
       			
		
				
	                                             }              
	}

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
                 <a href="ownerhomeupdate.php"> <li>Edit my fleet</li>
                 <a href="busstatuscon.php"> <li>Bus status and reports </li>
                
                </ul>


                 

                 <li>
                     <a href="ownerhome21.php ">
                  <i class="fa fa-users fa-lg"></i> Managers
                  </a>
                </li>
				
				
                 <li>
                     <a href="ownerhome41.php ">
                  <i class="fa fa-users fa-lg"></i> Drivers
                  </a>
                </li>
				
				
                 <li>
                  <a href="ownerhome31.php">
                  <i class="glyphicon glyphicon-search"></i> search Busses
                  </a>
                  </li>
                  <li>
                  <a href="ownerhome51.php">
                  <i class="glyphicon glyphicon-wrench"></i> commands
                  </a>
                  </li>
            </ul>
     </div>
</div
</html>