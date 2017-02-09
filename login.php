<?php
  include ("../dbaccount.php");
  $db = mysql_connect ($dbHost, $dbUser, $dbPass)
         or die ("Unable to connect to the database");
         
  mysql_select_db($database);

  $user = mysql_real_escape_string($_POST["user"]);
  $pass = mysql_real_escape_string($_POST["pass"]); 

  $query = "SELECT * FROM Users WHERE user='$user' AND pass='$pass'";
  
  $result = mysql_query ( $query )
  
  if ($result != FALSE)
  {
    echo 1;
  } else
  {
    echo 0;
  }
  
  mysql_close($db);
  exit();
?>
