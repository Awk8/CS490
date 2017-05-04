<html>
<head>
<title>Welcome</title>
<link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="center">
<?php
session_start();
include 'php/comps.php';
$user = $_SESSION["user"];
$role = $_SESSION["role"];

auth($role);
nav($role);

echo "<br><h1 style=\"font-size:300%;\" align=\"center\">Home Page</h1><br><pre> Welcome ". $user . "!</pre><pre> You are logged in as a ". $role ."!</pre><pre> Please use the bar above to navigate the site.</pre>";

 ?>
 </div> 
</body>
</html>
