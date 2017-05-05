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

foreach ($_POST as $key => $value) {
      if(strcmp(trim($value), trim("on")) == 0){
        $examId = $key;
      }
}

$json_obj = json_encode(array( "selectExamObject"=> array($examId => null) ));
$result = toMID($json_obj);
$a = json_decode($result,true);

$json_obj2 = json_encode(array( "getExamQuestions"=> $a[0]["questions"]));
$result2 = toMID($json_obj2);
$b = json_decode($result2,true);

$json_obj3 = json_encode(array( "getAnsweredQuestions"=> array('examId' => $examId, 'user' => $user) ));
$result3 = toMID($json_obj3);
$c = json_decode($result3,true);

$json_obj4 = json_encode(array( "getGrades"=> $user ));
$result3 = toMID($json_obj4);
$d = json_decode($result3,true);

?>
<div class="center">
<form action="" method="post">
<?php
$grade = 0;
for($i = 0; $i < sizeof($d); $i++){
  if(strcmp($d[$i]["exam"],$examId) == 0)
    $grade = $d[$i]["grade"];
}

for($x = 0; $x < sizeof($b); $x++){
  $qNum = $x+1;
  $qQuest = $b[$x]["question"];
  $qId = $b[$x]["id"];
  $qDiff = $b[$x]["difficulty"];
  $qUserAns = $c[$x]['answer'];
  $qKeyAns = $b[$x]['answer'];
  $qGivenPoints = $c[$x]['correct'];
  $cases = explode(":",$c[$x]['case']);
  echo "<h3>$qNum.) $qQuest";
  echo "<br><textarea readonly style='width:300px;height:175px;'>$qUserAns</textarea><textarea readonly style='width:300px;height:175px;border-color:green;border-width:3px;'>$qKeyAns</textarea><br>";
  echo "<br>Points:".$qGivenPoints;
}
$feedback = $_POST["feedback".$examId];
echo "<br><br><br><h2> Final Grade: $grade </h2>";
echo "<br><br><textarea style='width:500px;height:200px' readonly name='feedback'>$feedback</textarea><br><br>";


?>
