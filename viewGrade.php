<html>
<head>
<title>Viewing Grades</title>
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

$json_obj = json_encode(array( "getGrades"=> $user ));
$result = toMID($json_obj);
$a = json_decode($result,true);
?>
<div class="center">
<h2>Results from your exams!</h2>

<form action="viewExam.php" method="post">
<table border="1" width='800px' align="center" bgcolor='#FFF'>
<tr><td>Select</td><td>Exam TItle</td><td>Grade</td><td>Feedback</td></tr>
<?php
for($x = 0; $x < sizeof($a); $x++){
  $exam = $a[$x]["title"];
  $grade = $a[$x]["grade"];
  $feed = $a[$x]["feedback"];
  $examId = $a[$x]["id"];

  $form1 = "<input type=radio name='$examId'>";
  echo "<tr><td>$form1</td><td>$exam</td><td>$grade</td><td><textarea readonly name='feedback$examId'>$feed</textarea></td></tr>";
}
?>
</table>
<br>
<input type="submit" value="View Answers" name="submit">

</div>
</body>
</html>
