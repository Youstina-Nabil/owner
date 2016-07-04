<?php
error_reporting(E_ALL ^ E_DEPRECATED &~E_NOTICE);
session_start();


//error_reporting(E_ALL ^ E_DEPRECATED &~E_NOTICE);
require ('config.php');


    
if(isset($_POST['submit']))
{   
	$v3=$_POST['pwd'];
    $v4=$_POST['email'];
	$v1=$_POST['company'];
    if($v3==""||$v3==null || $v4==""||$v4==null || $v1==""||$v1==null )
	{echo'
             <div class="alert alert-danger">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                 <strong>Error !</strong> Fields cannot be empty ! .
             </div>'
    ;}
elseif(!isset($_POST['user']))
    {
	echo"
<footer>
<p>Please check one of them </p>
</footer>"
;
	}
   
else{
	     $selected_radio =$_POST['user'];
		
		if ($selected_radio == 'owner')
			{ 
             $sql="select * from fleetowner where  Email='$v4' AND PW='$v3' AND CompanyName='$v1' ";
             $result  = mysql_query($sql);   
		     if(!mysql_query($sql))
               {
                 die('Error :'.mysql_error());
               }
			   
			   while($row = mysql_fetch_array($result)){$fleetid=$row['FleetOwnerId'];$companyname=$row['CompanyName'];$username=$row['UserName'];}
			   echo $fleetid ;
              $res = mysql_query("select Email from fleetowner where  Email='$v4' AND PW='$v3' AND CompanyName='$v1'"    );            	
                if (mysql_num_rows($res)) {
                          mysql_free_result($res);    $_SESSION["id"] = $fleetid;
                            $_SESSION["cname"] = $companyname;  $_SESSION["username"] = $username; 
                             header("Location:ownerhome21.php"); 
			                               }
                                 
                else  
                {  
		        echo "<footer>
		              <p>Invalid password or e-mail</p>
		              </footer>";
                }      
            }	  
		if ($selected_radio == 'manager')
			{ 
             $sql="select Email from manager where  	ManagerEmail='$v4' AND PW='$v3' AND CompanyName='$v1' ";
             $result  = mysql_query($sql);   
		     if(!mysql_query($sql))
               {
                 die('Error :'.mysql_error());
               }
             $res = mysql_query( "select Email from manager where  	ManagerEmail='$v4' AND PW='$v3' AND CompanyName='$v1'"    );            	
                if (mysql_num_rows($res)) {
                          mysql_free_result($res);
                             header("Location:managerhome.php"); 
			                               }
                                 
                else  
                {  
		        echo "<footer>
		              <p>Invalid password or e-mail</p>
		              </footer>";
                }     
            }	  	 
			 
			 
//$db->close();
}

} ?>



<html>
   
    
    <head>
    

       
  
   
	<head>
  <title>Fleet Tracking System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  
  <!-- nav bar style yt7at fel head bta3 ay file -->
  <style>
      .navbar {
    margin-bottom: 0;
    background-color: black;
    z-index: 9999;
    border: 0;
    font-size: 12px !important;
    line-height: 1.42857143 !important;
    letter-spacing: 4px;
    border-radius: 0;
    font-size:2em;
}

.name{
    letter-spacing: 2px;
    color: #fff !important;
    background-color: red!important;
    
}

.name:hover{
    
    letter-spacing: 2px;
    color: #fff !important;
    background-color: darkred ;
}
.navbar li a, .navbar .navbar-brand {
    color: #fff !important;
}

.navbar-nav li a:hover, .navbar-nav li.active a {
    color: #1804ad !important;
    background-color: darkred !important;
}

.navbar-default .navbar-toggle {
    border-color: transparent;
    color: #fff !important;
}



  </style>
	</head>
    <body>
	     <nav class="navbar navbar-default navbar-fixed-top">
           
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        
      </button>
      <a class="navbar-brand" href="#">Vehicle Tracking System</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        
        <li><a href="#fleet">Home</a></li>
        <li><a href="#about">Log-out</a></li>
        <li class="name"><a >Shymaa Tarek</a></li>
      </ul>
    </div>
  </div>
</nav>
         
	    <div class="container"> 
               
                
                <img src='images/red.jpg' style='position:fixed;top:0px;left:0px;width:100%;height:100%;z-index:-1;'>

 
    
    
    
    
    
    <div class="regiter" class="text-right">
                    <div id="container-fluid">
			                   		
                      <form name="loginform" onsubmit="submitfn()"  action="signin.php" method="post" >
			
                      <div class="container-fluid">
                      <div class="row">
                    
                      <div class="col-md-4" align="left" > 
                          <div class="container-fluid">
                              <div class="panel panel-default " style="margin-top:100px;width: 500px;height: 650px; background: rgba(255, 255, 255, 0.65)" >
                          
                                  <div class="panel-heading" style="font-size:25px ;">login</div> 
                                 
				    <div class="panel-body">   <input  type = "text" class = "form-control" id="email"     name="email" placeholder="Please entre your e-mail" /><br>
                       <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Please entre your password" /><br>
					   <input  type = "text" class = "form-control" id="company"     name="company" placeholder="Please entre your company name" /><br><br>
                      
					   <input type="radio"  name="user" value="owner">as Fleet Owner <br>
					   <input type="radio"  name="user" value="manager">as BusYard Manager<br><br>
					  <button id="submit" name="submit" type="submit" class="btn btn-danger btn-lg">log in </button>
     </div>                                                     

                          </div>     
                                     </div>     
                                          
                          </div>    
                                          
                                          
                                          
                                          
                                 <div class="col-md-4"></div>
                       <div class="col-md-4"></div>           
                                          
                                          
                                          
                                          
                                          
                                          
                                          
                                          
                                          
                                          
                                          
                                          

</div>

</div></div>




                      </form></div>
                    </div>
    
    
    
    
    
    
    
    
    
    
    
    
    
        
    
</div>  
	<nav class="navbar navbar-default navbar-fixed-top">
           
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        
      </button>
      <a class="navbar-brand" href="#">Vehicle Tracking System</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        
        <li><a href="#fleet">Home</a></li>
        <li><a href="#about">Arkb-eh?</a></li>
      
      </ul>
    </div>
  </div>
</nav>	
	</body>
</html>



