<html>
<head>
<title>Select Exam</title>
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

$json_obj = json_encode(array( "getExams" => null ));
$result = toMID($json_obj);
$form_data = $result;

$json_obj2 = json_encode(array( "getPickExam" => $user));
$result2 = toMID($json_obj2);
$form_data2 = $result2;

 ?>
<div class="center">
<h1>Please select the exam you wish to take</h1>
<form action="takeExam.php" method="post">
  <?php
    $a = json_decode($form_data,true);
    $b = json_decode($form_data2,true);

    $arrayLength = count($a);
    $arrayLength2 = count($b);

    $x = 0;
    $y = 0;
    echo "<table border='1' width='800px' align='center' bgcolor='#FFF'>";
    echo "<tr><th>Select</th><th>Exam Name</th><th>Description</th><th>Difficulty</th>";
    echo "</tr>";
    while($x < $arrayLength){
      $y = 0;
      while($y < $arrayLength2){

          if(strcmp($b[$y]["exam"],$a[$x]["id"]) == 0) {
            $x++;
            continue 2;
          }
        $y++;
      }

      $id = $a[$x]["id"];
      $title = $a[$x]["title"];
      $desc = $a[$x]["description"];
      $diff = $a[$x]["difficulty"];
      echo "<tr><td align='center'><input type='radio' name='$id'></td><td>$title</td><td>$desc</td><td>$diff</td></tr>";
      $x++;
    }
    echo "</table>";
  ?>
   <input type="submit" name="submit" value="Take Exam">
</form>
</div>
</body>
</html>
