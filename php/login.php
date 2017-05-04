<?php
$username = $_POST["user"];
$password = $_POST["pass"];

session_start();

if(isset($_SESSION['user']))
  unset($_SESSION['user']);
if(isset($_SESSION['role']))
  unset($_SESSION['role']);

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL,"https://web.njit.edu/~kkc22/CS490proj/auth.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS,"user=".$username."&pass=".$password);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$return = curl_exec ($curl);
curl_close ($curl);

$data = json_decode($return);

if($data->Role){
  $_SESSION['user'] = $username;
  $_SESSION['role'] = $data->Role;
  echo 1;
}
?>
