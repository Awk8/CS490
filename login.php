<html>
  <body>
    <?php
      include ("../dbaccount.php");
      mysql_connect ($dbHost, $dbUser, $dbPass);
    
      mysql_select_db('awk8');
    
      $user = mysql_real_escape_string($_POST["user"]);
      $pass = mysql_real_escape_string($_POST["pass"]); 
    
      $query = "SELECT * FROM Users WHERE user='$user' AND pass='$pass'";
      $result = mysql_query($query);
      $rows = mysql_num_rows($result);
    
      if ($rows >= 1)
      {
        print "Pass";
      } else
      {
        print "Fail";
      }
      exit;
    ?>
  </html>
</body>
