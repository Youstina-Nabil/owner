 <?php
 session_start();

error_reporting(E_ALL ^ E_DEPRECATED &~E_NOTICE);
require ('config.php');
$companyname=$_SESSION["cname"];$username=$_SESSION["username"]; 


echo 
'
<html>

    <head>
    <img  src="images/gr.png" class="img-responsive"   style="position:fixed;top:0px;left:0px;width:100%;height:100%;z-index:-1;" >
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Vehicle Tracking Systtem</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
        
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



         <body>
         <div class="row"> <div class="col-md-3"></div>   
        <div class="col-md-6">    <div class="panel panel-default" style="margin-top:50 ">
               <div class="panel-heading"><b>Search</b></div>
               <div class="panel-body" > 
			   
               <form action="ownerhome31.php" onsubmit="submitfn()"  method="post" >
         <div class="col-sm-3" align=right>      Filter By Station</div> <div class="col-sm-6"> <select size="1" name="D1" placeholder="One Station"class="form-control";';
                        echo "<option>--</option> ";
                        echo '<option value="" disabled selected hidden></option> ';
	
$sql = "SELECT DISTINCT BusStationName FROM `assigned_to` INNER JOIN  `busline`  on assigned_to.BusNo=busline.BusNo and assigned_to.BusLineName=busline.BusLineName where  CompanyName='$companyname' and OwnerUserName='$username' ";
$query = mysql_query($sql);
while($row = mysql_fetch_array($query))
{	$x=$row['BusStationName'];         
      echo "<option>$x</option> " ;
}        
echo '</select> <br>
    </div>
<div class="col-sm-3">
<input type="submit" name="submit" value="Find" class="btn btn-danger  " ></div><br><br> <br>  

<div class="col-sm-3" align=right>  
Filter By Line </div>
<div class="col-sm-6">
	<select size="1" name="D2" class="form-control";';
echo "<option>--</option> ";
echo '<option value="" disabled selected hidden> </option> ';



					   
$sql1 = "SELECT * FROM  assigned_to  INNER JOIN  `busline`  on assigned_to.BusNo=busline.BusNo and assigned_to.BusLineName=busline.BusLineName where CompanyName='$companyname' and OwnerUserName='$username'  ";
$query1 = mysql_query($sql1);
 if(!mysql_query($sql1)){die('Error :'.mysql_error());}
while($row1 = mysql_fetch_array($query1))
{	$bl=$row1['BusLineName'];       					   
	echo "<option>$bl</option> ";
} 
echo' </select> </div>';
                    
echo   ' <div class="col-sm-3" >   <input type="submit" name="submit1" value="Find" class="btn btn-danger" ></div>
                   	   </form>
					   ';

if (isset($_POST['submit'])) 
{  ;
if (empty($_POST['D1'])) 
   {
	  ;
   }
 else
   {
$station = filter_input(INPUT_POST, 'D1');
//$to = filter_input(INPUT_POST, 'D2');

$sql2 = "SELECT DISTINCT * FROM `assigned_to` INNER JOIN  `busline`  on assigned_to.BusNo=busline.BusNo and assigned_to.BusLineName=busline.BusLineName where  CompanyName='$companyname' and OwnerUserName='$username' and BusStationName='$station' ";
    $query2 = mysql_query($sql2);
    if(!mysql_query($sql2)){die('Error :'.mysql_error());}
     while( $row2= mysql_fetch_array($query2)){
             $busno= $row2['BusNo'];
             echo $busno , "<br> ";
	}                                        }
}
if (isset($_POST['submit1'])) 
{ 
if (empty($_POST['D2'])) 
   {
	   
   }
 else
   {
$bl = filter_input(INPUT_POST, 'D2');

$sql3 = "SELECT  * FROM  `busline` where BusLineName='$bl' and  CompanyName='$companyname' and OwnerUserName='$username'   ";
    $query3 = mysql_query($sql3);
    if(!mysql_query($sql3)){die('Error :'.mysql_error());}
     while( $row3= mysql_fetch_array($query3)){
             $busno= $row3['BusNo'];
             echo $busno , "<br> ";
	}                                        }
}
					   
					   
			   
echo '		   </div>
			   </div>
                           
</div><div class="col-md-3"></div>
		 </body>	 
</html>';	 




?>

<html>
    
    
  
</html>
