<?php

$username = $_POST["user"];
$password = $_POST["pass"];

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL,"https://web.njit.edu/~awk8/cs490backend/Test2/php/functions.php");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS,"user=" . $username . "&pass=" . $password . "&function=1");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$return = curl_exec ($curl);
curl_close ($curl);

echo $return;

?>
