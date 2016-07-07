<?php
error_reporting(E_ALL ^ E_DEPRECATED &~E_NOTICE);

 include("config.php");
if($_POST['id'])
{
	
$id=mysql_escape_String($_POST['id']);
$by=mysql_escape_String($_POST['by']);
$sql="select * from busyard where Name='$by' ";
$query = mysql_query($sql);
  
if(mysql_num_rows($query)>0)
{
$sql = "update supervise set YardName='$by' where AccountId	='$id'";
mysql_query($sql);
}

}
?>