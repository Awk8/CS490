<?php
//path "https://web.njit.edu/~awk8/CS490BackEnd/Beta/Queries.php"
include ("../dbaccount.php");

$db = mysql_connect ($dbHost, $dbUser, $dbPass); or die ( "Unable to connect to the database..." );
       
mysql_select_db( $dbUser );

$function = mysql_real_escape_string($_POST["function"]);

switch ($function) 
{
    case 1:
      $username = mysql_real_escape_string($_POST["user"]);
      $password = mysql_real_escape_string($_POST["pass"]); 
      login($username,$password);
      break;
    case 2: 
      $q = mysql_real_escape_string($_POST["question"]);
      $a = mysql_real_escape_string($_POST["answer"]); 
      $d = mysql_real_escape_string($_POST["difficulty"]);
      $c1 = mysql_real_escape_string($_POST["case1"]);
      $c2 = mysql_real_escape_string($_POST["case2"]);
      $c3 = mysql_real_escape_string($_POST["case3"]);
      storeQuestion($q, $a, $d, $c1, $c2, $c3);
      break;
    case 3: 
      getQuestions();
      break;
    case 4: 
      $title = mysql_real_escape_string($_POST["testName"]);
      $test = mysql_real_escape_string($_POST["test"]);
      $avgDifficulty = mysql_real_escape_string($_POST["avgDifficulty"]);        
      makeTest($title,$test,$avgDifficulty);
      break;
    case 5: 
      getTests();
      break;
    case 6: 
      $testID = mysql_real_escape_string($_POST["testID"]);
      getATest($testID);
      break;
    case 7:
      $username = mysql_real_escape_string($_POST["user"]);
      $testID = mysql_real_escape_string($_POST["testID"]);
      $grade = mysql_real_escape_string($_POST["grade"]);
      storeGrade($username,$testID,$grade);
      break;
    case 8:
      getGrades();
      break;
    case 9:
      $username = mysql_real_escape_string($_POST["user"]);
      $testID = mysql_real_escape_string($_POST["testID"]);
      getSpecGrade($username, $testID);
      break;
    default:;
}

function login($user,$pass)
{
	$query = "SELECT * FROM USERS WHERE Username='$user' AND Password='$pass'";
	($result = mysql_query ($query)) or die (mysql_error());

	if(mysql_num_rows ($result) >= 1)
  {
    $row = mysql_fetch_array($result);
  print json_encode($row);
  }
}

function storeQuestion($question, $answer, $difficulty, $case1, $case2, $case3)
{
  $query = "INSERT INTO `Questions` VALUES (id,'$question','$answer','$difficulty','$case1','$case2','$case3')";
	($result = mysql_query ( $query )) or die (mysql_error());

	if(mysql_num_rows ($result) >= 1)
  {
    $row = mysql_fetch_array($result);
    print json_encode($row);
  }
}

function getQuestions()
{
  $query = "SELECT * FROM Qustions";
	($result = mysql_query ($query)) or die (mysql_error());
  $dbArray = array();
	if(mysql_num_rows ($result) >= 1)
  {
     while ($row = mysql_fetch_array($result)) 
     {
       $dbArray[]= $row;
     }
    print json_encode($dbArray);
  }
}

function makeTest($title,$test,$avgDifficulty)
{
  $query = "INSERT INTO `Tests` VALUES (id,'$title','$test','$avgDifficulty')";
	($result = mysql_query ($query)) or die (mysql_error());

	if(mysql_num_rows ($result) >= 1)
  {
    $row = mysql_fetch_array($result);
    print json_encode($row);
  }
}

function getTests()
{
  $query = "SELECT * FROM Tests";
	($result = mysql_query ($query)) or die (mysql_error());
  $dbArray = array();
	if(mysql_num_rows ($result) >= 1)
  {
    while ($row = mysql_fetch_array($result)) 
    {     
      $dbArray[]= $row;
    }
    print json_encode($dbArray);
  }
}

function getATest($id)
{
  $query = "SELECT * FROM Tests WHERE id='$id'";
	($result = mysql_query ($query)) or die (mysql_error());
  $dbArray = array();
	if(mysql_num_rows ($result) >= 1)
  {
     while ($row = mysql_fetch_array($result)) 
     {
       $dbArray[]= $row;
     }
    print json_encode($dbArray);
  }
}

function storeGrade($username, $testID, $grade)
{
  $query = "INSERT INTO `Grades` VALUES ('$testID','$username','$grade')";
	($result = mysql_query ($query)) or die (mysql_error());

	if(mysql_num_rows ($result) >= 1)
  {
    $row = mysql_fetch_array($result);
    print json_encode($row);
  }
}

function getGrades()
{
  $query = "SELECT * FROM Grades";
	($result = mysql_query ($query)) or die (mysql_error());
  $dbArray = array();
	if(mysql_num_rows ($result) >= 1)
  {
    while ($row = mysql_fetch_array($result)) 
    {     
      $dbArray[]= $row;
    }
    print json_encode($dbArray);
  }
}

function getSpecGrade($username, $testID)
{
  $query = "SELECT * FROM Grades WHERE Username='$username' AND Test='testID'";
	($result = mysql_query ($query)) or die (mysql_error());
  $dbArray = array();
	if(mysql_num_rows ($result) >= 1)
  {
    while ($row = mysql_fetch_array($result)) 
    {     
      $dbArray[]= $row;
    }
    print json_encode($dbArray);
  }
}

mysql_close($db);
exit();
?>
