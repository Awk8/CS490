<html>
<head>
<title>Submit Exam</title>
<link rel="stylesheet" href="css/styles.css">
<script>
</script>
</head>
<div class="center">
<body>

<?php
session_start();
include 'php/comps.php';
$user = $_SESSION["user"];
$role = $_SESSION["role"];
auth($role);
nav($role);


if(isset($_POST['submit'])){ //check if form was submitted
  $json_obj = json_encode(array( "submitExamObject"=> $_POST ));
  $result = toMID($json_obj);
  //$message = json_decode($result,true);
  $message = "Exam submitted. <br>Please wait for the professor to release grades.";
}
 ?>
 <h2>
<?php
    echo $message;
    //echo $result;
?></h2>
</body>
</div>
</html>
