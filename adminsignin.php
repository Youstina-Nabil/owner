<html >
  <head>
    <meta charset="UTF-8">
    <title>ADMIN</title>
         <link rel="stylesheet" href="adminstyle.css">
  </head>
  <body>
  <div class="login-page">
  <div class="form">
    <form method="post"  action="adminsignin.php" >
      <input type="text" id="id" name="id"  placeholder="Your ID"/>
      <input type="password" id="pw" name="pw"  placeholder="password"/>
      <button id="submit" name="submit" type="submit" >login</button>
    </form>
  </div>
 </div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    </body>
</html>

<?php
	error_reporting(E_ALL ^ E_DEPRECATED &~E_NOTICE);
    require ('config2.php'); 
	
	if(isset($_POST['submit'])  && isset($_SERVER['REQUEST_URI']) )
    { 
	$v1=$_POST['id'];
    $v2=$_POST['pw'];

    if($v1==""||$v1==null || $v2==""||$v2==null  )
	{echo'
             <div class="alert alert-danger">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Fields cannot be empty ! .
  </div>'
    ;}

   
else
    {

	
             $sql = "select EmployeeID from admin where  EmployeeID='$v1' AND PW='$v2' ";
             $result = mysql_query($sql);   
		     if(!mysql_query($sql))
               {
                 die('Error :'.mysql_error());
               }
                if (mysql_num_rows($result)) {
                          mysql_free_result($result);
                              $_SESSION["ID"] = $v1;
$_SESSION["PW"] = $v2;
                             header("Location:adminsh.php"); 
			                               }
                                 
                else  
                {  
		            echo "<footer>
		              <p>Invalid password or E-mail</p>
		              </footer>";
                }     
    }

			 
}



?>    
    


