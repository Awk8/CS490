<html>
  <body>
    <?php
      include ("../dbaccount.php");

      $db = mysql_connect ($dbHost, $dbUser, $dbPass);

      mysql_select_db($database);

      $user = mysql_real_escape_string($_POST["user"]);
      $pass = mysql_real_escape_string($_POST["pass"]); 
      $uuid = mysql_real_escape_string($_POST["uuid"]); 

      $query = "SELECT * FROM Users WHERE user='$user' AND pass='$pass'";
      
      $result = mysql_query ( $query )

      if ($result != FALSE)
      {
        print "Pass";
      } else
      {
        print "Fail";
      }
      
      mysql_close($db);
      exit();
    ?>
  </body>
</html>
