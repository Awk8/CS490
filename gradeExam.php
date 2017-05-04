<html>
<head>
<title>Grading Exams</title>
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
authProf($role);
nav($role);

$json_obj = json_encode(array( "getExamAnswers"=> null ));
$result = toMID($json_obj);
$a = json_decode($result,true);
 ?>
 <div class="center">

 <h1>Release Grades</h1>

<h3>Please select student exam to grade</h3>
<form action="gradeQuestions.php" method="post">
<table border="1" width="800px" align="center" bgcolor="#FFF"><tr><th>Select</th><th>Exam Name</th><th>Student ID</th></tr>

<?php
for($x = 0; $x < sizeof($a); $x++){
  $examName = $a[$x]["title"];
  $examId = $a[$x]["exam"];
  $userName = $a[$x]["username"];
  $form3 = "<input name='user' hidden value='$userName'>";

  $form = "<input type='radio' name='$examId'>";
  echo "<tr><td>$form $form3</td><td>$examName</td><td>$userName</td></tr>";

}
?>
</table>
<br>
<input type="submit" value="Grade Exam" name="submit">
</form>
</div>
</body>
</html>
