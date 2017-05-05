<html>
<head>
<title>Taking Exam</title>
<link rel="stylesheet" href="css/styles.css">
<script>
</script>
</head>
<body>

<?php
session_start();
include 'php/comps.php';
$user = $_SESSION["user"];
$role = $_SESSION["role"];
auth($role);
nav($role);


if(isset($_POST['submit'])){ 
  $json_obj = json_encode(array( "selectExamObject"=> $_POST ));
  $result = toMID($json_obj);
  $a = json_decode($result,true);

  $json_obj2 = json_encode(array( "getExamQuestions"=> $a[0]["questions"]));
  $result2 = toMID($json_obj2);
  $b = json_decode($result2,true);
}
 ?>
<?php
    echo "<h1>Exam Title: ".$a[0]["title"]."</h1>
          <h2>Exam Description: ".$a[0]["description"]."</h2>";
?>
<div class="center">
<h4>All answers should be written in Java! </h4>
<form action="submitExam.php" method="post">
<?php
$examId = $a[0]["id"];
echo "<input name='examId' hidden value='$examId'>";
echo "<input name='user' hidden value='$user'>";
for($x = 0; $x < sizeof($b); $x++){
  $qNum = $x+1;
  $qQuest = $b[$x]["question"];
  $qId = $b[$x]["id"];
  $qDiff = $b[$x]["difficulty"];
  echo "<h3>$qNum.) $qQuest</h3>Difficulty: $qDiff<br>";
  echo "<textarea name='$qId' placeholder='Insert answer here...' style='width:400px;height:125px' required></textarea><br>";
}
?>
<input type="submit" value="Submit Exam" name="submit">
</form>
</div>
</body>
</html>
