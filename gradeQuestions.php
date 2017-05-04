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

if(isset($_POST['graded'])){

  $questions = explode(",",$_POST["questions"]);

  for($i=0; $i < sizeof($questions); $i++){
    $info = array();
    $info["user"] = $_POST["user"];
    $info["examId"]  = $_POST["examId"];
    $info["question"]  = trim($questions[$i]);
    $given = $_POST[trim($questions[$i])."_given"];
    $total = $_POST[trim($questions[$i])."_total"];
    $info["grade"]  = $given."/".$total;
    $json_obj = json_encode(array( "updateQuestionGrade"=> $info ));
    $a = toMID($json_obj);
  }
  $info = array();
  $info = $_POST;
  $info["grade"] = $_POST["score"]."/".$_POST["total"];
  $json_obj = json_encode(array( "releaseGrades"=> $info ));
  $b = toMID($json_obj);
  $b = "The Exam have been released to the students.";
  echo "<h2>".$b."</h2>";

  exit();
}

if(isset($_POST['submit'])){

  foreach ($_POST as $key => $value) {
        if(strcmp(trim($value), trim("on")) == 0){
          $examId = $key;
        }
  }
  $username = $_POST['user'];

  $json_obj = json_encode(array( "selectExamObject"=> array($examId => null) ));
  $result = toMID($json_obj);
  $a = json_decode($result,true);

  $json_obj2 = json_encode(array( "getExamQuestions"=> $a[0]["questions"]));
  $result2 = toMID($json_obj2);
  $b = json_decode($result2,true);

  $json_obj3 = json_encode(array( "getAnsweredQuestions"=> array('examId' => $examId, 'user' => $username) ));
  $result3 = toMID($json_obj3);
  $c = json_decode($result3,true);
}
 ?>
 <div class="center">

 <h1>Grade Exam</h1>


 <div class="center">
 <form action="" method="post">
 <?php
 $questions = $a[0]["questions"];
 echo "<input name='examId' hidden value='$examId'>";
 echo "<input name='user' hidden value='$username'>";
 echo "<input name='questions' hidden value='$questions'>";
 for($x = 0; $x < sizeof($b); $x++){
   $qNum = $x+1;
   $qQuest = $b[$x]["question"];
   $qId = $b[$x]["id"];
   $qDiff = $b[$x]["difficulty"];
   $qUserAns = $c[$x]['answer'];
   $qKeyAns = $b[$x]['answer'];
   $qGivenPoints = $c[$x]['correct'];
   $cases = explode(":",$c[$x]['case']);
   $allCases = "";
   for($i = 0; $i < sizeof($cases); $i++){
     $allCases .= $cases[$i]."  ";
   }
   echo "<h3>$qNum. $qQuest</h3>";
   echo "Points Given: <input type=text class='Gpoints' name='$qId.given' value='$qGivenPoints' onChange='updateTotal()'><br>";
   echo "<br>Total Points: <input type=text class='Qpoints' name='$qId.total' value='5' onChange='updateTotal()'><br>";
   echo "<br><textarea readonly style='width:200px;height:125px;' >$qUserAns</textarea><textarea readonly style='width:200px;height:125px;border-color:green;border-width:3px;'>$qKeyAns</textarea><br>";
   echo "Cases Correct:".$allCases;
 }

 echo "<br><br>Total Exam Grade: <input type=text name='score' id='grade'> / <input type=text name='total' id='total' >";
 echo "<br><br><textarea style='width:500px;height:200px' name='feedback' placeholder='Exam feedback area'></textarea><br><br>";
 ?>
 <input type="submit" value="Submit Grade" name="graded">
 <script>
  function updateTotal() {
    var Gpoints = document.getElementsByClassName("Gpoints");
    var Qgrade = document.getElementsByClassName("Qpoints");

    var totalGrade = 0;
    for (var i = 0; i < Gpoints.length; i++ ){
      totalGrade += parseInt(Gpoints[i].value);
    }
    document.getElementById("grade").value = totalGrade;

    var totalPoints = 0;
    for(var i = 0; i < Qgrade.length; i++){
      totalPoints += parseInt(Qgrade[i].value);
    }
    document.getElementById("total").value = totalPoints;
  }
  var Gpoints = document.getElementsByClassName("Gpoints");
  var totalGrade = 0;
  for (var i = 0; i < Gpoints.length; i++ ){
    totalGrade += parseInt(Gpoints[i].value);
  }
  document.getElementById("grade").value = totalGrade;

  var Qgrade = document.getElementsByClassName("Qpoints");
  var totalPoints = 0;
  for(var i = 0; i < Qgrade.length; i++){
    totalPoints += parseInt(Qgrade[i].value);
  }
  document.getElementById("total").value = totalPoints;
 </script>
 </div>
