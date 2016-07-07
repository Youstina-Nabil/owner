<img  src="images/gr.png" class="img-responsive"   style='position:fixed;top:0px;left:0px;width:100%;height:100%;z-index:-1;' >
<title>Fleet Tracking System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  
<html>
    
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Vehicle Tracking Systtem</title>
	<link rel="stylesheet" href="ownerstyle.css" type="text/css">
	</head>
	
        
        
        
	     <script type="text/javascript" src="http://ajax.googleapis.com/
ajax/libs/jquery/1.5/jquery.min.js"></script>
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
$(".edit_tr").click(function()
{
var ID=$(this).attr('id');
$("#by_"+ID).hide();
$("#by_input_"+ID).show();


}).change(function()
{
var ID=$(this).attr('id');
var by=$("#by_input_"+ID).val();


//var LP=$("#lp_"+ID).val();
var dataString = 'id='+ ID +'&by='+by;
$("#by_"+ID).html('<img src="load.gif" />'); // Loading image

if(by.length>0)
{


$.ajax({
type: "POST",
url: "managerupdate_edit_ajax.php",
data: dataString,
cache: false,
success: function(html)
{
$("#by_"+ID).html(by);

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
#panel, #flip ,#flip1, #panel1,#flip2, #panel2,#flip3, #panel3{
	color: black;
    padding: 5px;
    text-align: center;
    background-color: #f3f3f3;
    border: solid 1px #f3f3f3;
}

#panel, #panel1,#panel2,#panel3{
    padding: 50px;
    display: none;
}
</style>
         <body>
         
<form name="own" action="ownerhome21.php" onsubmit="submitfn()"  method="post">
              <div class="col-lg-3"></div>
	<div class="col-lg-6" " > 
     
    <table class="table table-striped" style="margin-top: 50">
		  <tr>
            <th></th>		  
		    <th>Manager Name</th>
            <th>Manager ID</th>
			<th>Manager Email</th>
		    <th> Phone </th>
		    <th>  City</th>
		    <th>  Street</th>
		    <th colspan=10> Assigned Bus Lines</th>
		 </tr>
<?php
session_start();
error_reporting(E_ALL ^ E_DEPRECATED &~E_NOTICE);
require ('config.php');$companyname=$_SESSION["cname"];$username=$_SESSION["username"]; 
$sql = "SELECT * FROM `manager` where  CompanyName='$companyname' and OwnerUserName='$username' ";
$query = mysql_query($sql);
if(!mysql_query($sql)){die('Error :'.mysql_error());}


//$id=0;
while($row = mysql_fetch_array($query))
{
$fname=$row['ManagerFName'];
$lname=$row['ManagerLName'] ;	
$mi=$row['ManagerId']; 	
$id=$row['SubAccountId'];
$me=$row['ManagerEmail']; 
$mp=$row['ManagerPhoneNo'];
$mc=$row['ManagerCity'];
$ms=$row['ManagerStreet'];
?>		  
<tr id="<?php echo $id; ?>" class="edit_tr">
<td><input type="checkbox" name="removed[]" value= "<?php echo $id; ?>"  ></td>                    		    
<td class="table"><div><?php echo $fname; ?>  <?php echo $lname; ?></div></td>
 <td><div ><?php echo $mi; ?></div></td>
 <td><div><?php echo $me; ?></div></td>
 <td><div ><?php echo $mp; ?></div></td> 
 <td><div><?php echo $mc; ?></div></td>
 <td><div><?php echo $ms; ?></div></td>
	
<?php	
$sql1 = "SELECT  * FROM edit where SubAccountId=$id" ;
$query1 = mysql_query($sql1);           
if(!mysql_query($sql1)){die('Error :'.mysql_error());}
while($row1 = mysql_fetch_array($query1))
{ $bl=$row1['BusLineName'];
	
?>	

<td class="edit_td">
<span id="by_<?php echo $id; ?>" class="text"><?php echo $bl; ?></span> 
<input type="text" value="<?php echo $bl; ?>" class="editbox" id="by_input_<?php echo $id; ?>"/>
</td>

<?php
}
?>	  
</tr>
<?php
//$id ++;
}
?>

             <div class="col-lg-6" align="right">
 
 </table >
 <button type="submit" value="Remove " name="submit" class="btn btn-danger form-control">Remove Manager</button>
 </form> 
 <div id="flip" align="center"> ADD  Manager</div>

 
 <div id="panel"><?php  error_reporting(E_ALL ^ E_DEPRECATED &~E_NOTICE);
require ('config.php'); 
 echo'<style>select:required:invalid {
  color: black;
}
option[value=""][disabled] {
  display: none;
}
option {
  color: black;
}</style>
     <form method="post"  action="ownerhome21.php">   
     <input type="number" name="AccountId"  placeholder="Account ID"  step="1" required class="form-control" >
     <input type="password" id="pwd" name="pwd" placeholder="Initial Password" step="1" required class="form-control">
	 <input type="text" name="fname"  placeholder="First Name" step="1" required class="form-control"> 
     <input type="text" name="lname" placeholder="Last Name" step="1" required class="form-control">
     <input type="number" name="id" placeholder="ID"  step="1" required class="form-control">
     <input type="number" name="pno" placeholder="Phone Number" step="1" required class="form-control">
     <input type="text" name="email" placeholder="E-mail " step="1" required class="form-control">
     <input type="text" name="city" placeholder="City" step="1" required class="form-control">
     <input type="text" name="street" placeholder="Street "  step="1" required class="form-control">
	 <br>
	 <input type="submit" name="submit1" value="ADD" class="btn btn-danger"><br>  
                        </form> </div>
                     '
     
     ; 
     if(!isset($_POST['submit1']))
       {  }
      else{
		   if(isset($_POST['pwd']))
             {
               $pwd = $_POST['pwd'];
     	       $accid=$_POST['AccountId'];
		       $fname=$_POST['fname'];
               $lname=$_POST['lname'];
		       $ssn=$_POST['id'];
		       $num=$_POST['pno'];
		       $email=$_POST['email'];
		       $city=$_POST['city'];
		       $street=$_POST['street'];
			   $yardname= filter_input(INPUT_POST, 'D1');// echo $accid ; echo $yardname;	
			   $sql = "SELECT * FROM `manager` where ManagerID='$ssn' or ManagerEmail='$email' ";
               $query = mysql_query($sql);
               if(!mysql_query($sql)){die('Error :'.mysql_error());}  
               if(mysql_num_rows($query)>0){/*echo'This manager already exists';*/}
               else{
				       $sqlcheck="SELECT * FROM `manager` where PW='$pwd'";
					   $querycheck = mysql_query($sqlcheck);
					   if(mysql_num_rows($querycheck)>0){echo 'Change your Password to be unique';}
                       else{		
						//   $sqlin="INSERT INTO `supervise` (`AccountId`, `YardName`) VALUES ( $accid, '$yardname') ";
						   $sql1 = "INSERT INTO `manager`(`SubAccountId`, `PW`, `CompanyName`, `OwnerUserName`, `ManagerFName`, `ManagerLName`, `ManagerId`, `ManagerEmail`, `ManagerPhoneNo`, `ManagerStreet`, `ManagerCity`) 
				           VALUES ('$accid','$pwd','$companyname','$username','$fname','$lname','$ssn','$email','$num','$street','$city')  ";
                           $query1 = mysql_query($sql1);
                        //   $queryin = mysql_query($sqlin);
						//   if(!mysql_query($sqlin)){die('Error :'.mysql_error());}                  
     					   if(!mysql_query($sql1)){die('Error :'.mysql_error());}
	                       		
						   }						
				    }		
	        }
	   }
       
	   ?>
	   <br>
	   <div id="flip3">Assigne Manager to Line</div>
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
     <form method="post"  action="ownerhome21.php">   
          <select required size="1" name="name"                          
          <option>--</option><option value="" disabled selected hidden> Manager Name</option> 	';
		  
		  $sqlname = "SELECT * FROM `manager` where CompanyName='$companyname' and OwnerUserName='$username' ";
          $queryname = mysql_query($sqlname);
          while($rowname = mysql_fetch_array($queryname))
          {$fname=$rowname['ManagerFName'];
           $lname=$rowname['ManagerLName'] ;	
          
			echo "<option> $fname $lname </option> " ;
	    	
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
		   echo "<option>$busline:$busno</option> " ;
          }   
		  
		  
	 echo ' 
     	  </select>	  
		  
	<input type="submit" name="submit4" value="ADD" class="btn btn-danger"><br>  
                        </form>
	 ';
	 if(!isset($_POST['submit4']))
       {  }
      else{
		   if(isset($_POST['name']))
            {
				if(isset($_POST['no']))
                {			
			    $name=filter_input(INPUT_POST, 'name');
			    $num=filter_input(INPUT_POST, 'no');
				//$num1 = explode(" ", $name);
			    $managername = explode(" ", $name);
				list($line, $number) = explode(":", $num);
                $sqlget="SELECT * FROM `manager` where ManagerFName='$managername[0]' and ManagerLName='$managername[1]'";
			    $queryget = mysql_query($sqlget);
				while($rowget = mysql_fetch_array($queryget))
                    {	
							           $managerid=$rowget['SubAccountId'];       
                    } 					       
    			$sqlbl1="INSERT INTO `edit`(`SubAccountId`, `BusLineName`, `BusNo`) VALUES('$managerid','$line','$number')";
                $querybl1 = mysql_query($sqlbl1);
               
			   // if(!mysql_query($sqlbl1)){die('Error :'.mysql_error());}
			    
				}
			}
	  }
      ?>
	   
	   </div>
	   
	  


	   
	          </div>
              <div class="col-lg-3"></div>


</body>
</html>

<?php
if (isset($_POST['submit']))
{
	
if (empty($_POST['removed'])) 
{     
	
}
else {	
    
	foreach($_POST['removed'] as $selected) {
		
     //  	$sql2 = "DELETE FROM `supervise` WHERE AccountId= $selected  ";
     //   $query2 = mysql_query($sql2);
     //   if(!mysql_query($sql2)){die('Error :'.mysql_error());}	     
		$sql3 = "DELETE FROM `manager` WHERE SubAccountId= $selected  ";
        $query3 = mysql_query($sql3);
        if(!mysql_query($sql3)){die('Error :'.mysql_error());}		
		}
}

}
?>
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