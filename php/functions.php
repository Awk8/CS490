<?php
include ("account.php");
$dbh = mysql_connect ( $hostname, $username, $password );
mysql_select_db( $project );

$function = mysql_real_escape_string($_POST["function"]);

switch ($function) {
    case 1:
        $username = mysql_real_escape_string($_POST["user"]);
        $password = mysql_real_escape_string($_POST["pass"]); 
        login($username,$password);
        break;
    case 2: 
        $q = mysql_real_escape_string($_POST["question"]);
        $d = mysql_real_escape_string($_POST["diff"]);
        $c = mysql_real_escape_string($_POST["cases"]);
        makeQuestion($q,$d,$c);
        break;
    case 3: 
        getQuestions();
        break;
    case 4: 
        $title  = mysql_real_escape_string($_POST["examName"]);
        $desc   = mysql_real_escape_string($_POST["examDesc"]); 
        $diff   = mysql_real_escape_string($_POST["diff"]);
        $quest  = mysql_real_escape_string($_POST["questions"]);
        $points  = mysql_real_escape_string($_POST["pointVals"]);
        makeExam($title,$desc,$diff,$quest,$points);
        break;
    case 5: 
        getExams();
        break;
    case 6: 
        $examId  = mysql_real_escape_string($_POST["examID"]);
        getTakeExam($examId);
        break;
    case 7:
        $ids = mysql_real_escape_string($_POST["questions"]);
        getQuestion($ids);
        break;
    case 8:
        $examID = $_POST["examID"];
        $user = $_POST["user"];
        $question = $_POST["question"];
        $correct = $_POST["correct"];
        $answer = mysql_real_escape_string($_POST["answer"]);
        $case = mysql_real_escape_string($_POST["case"]);
        answerQuestion($user,$examID,$question,$correct,$answer,$case);
        break;
    case 9:
        getExamsAnswered();
        break;
    case 10:
        $examID = mysql_real_escape_string($_POST["examID"]);
        $user = mysql_real_escape_string($_POST["user"]);
        getCountQuestions($user,$examID);
        break;
    case 11:
        $examID = mysql_real_escape_string($_POST["examID"]);
        $user = mysql_real_escape_string($_POST["user"]);
        getCorrectQuestions($user,$examID);
        break;
    case 12:
        $examID = mysql_real_escape_string($_POST["examID"]);
        $user = mysql_real_escape_string($_POST["user"]);
        $grade = $_POST["grade"];
        $feedback = mysql_real_escape_string($_POST["feedback"]);
        insertGrades($examID,$user,$grade,$feedback);
        break;
    case 13:
        $user = mysql_real_escape_string($_POST["user"]);
        getExamResult($user);
        break;
    case 14:
        $user = mysql_real_escape_string($_POST["user"]);
        getPickExam($user);
        break;
    case 15:
        $user = mysql_real_escape_string($_POST["user"]);
        $exam = mysql_real_escape_string($_POST["exam"]);
        getAnsweredQuestions($user,$exam);
        break;
    case 16:
        $user = mysql_real_escape_string($_POST["user"]);
        $exam = mysql_real_escape_string($_POST["exam"]);
        $question = mysql_real_escape_string($_POST["question"]);
        $grade = mysql_real_escape_string($_POST["grade"]);
        updateQuestionGrade($user,$exam,$question,$grade);
        break;
    default:;
}

//1
function login($user,$pass){
	$query = "SELECT * FROM Users WHERE Username='$user' AND Password='$pass'";
	( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );

	if(mysql_num_rows ($queryRes) >= 1){
    $row = mysql_fetch_array($queryRes);
    print json_encode($row);
  }
}

//2
function makeQuestion($question,$difficulty,$c){
  $query = "INSERT INTO `questions` VALUES (id,'$question','$difficulty','$c')";
	( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );

	if(mysql_num_rows ($queryRes) >= 1){
    $row = mysql_fetch_array($queryRes);
    print json_encode($row);
  }
}

//3
function getQuestions(){
  $query = "SELECT * FROM questions";
	( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );
  $emparray = array();
	if(mysql_num_rows ($queryRes) >= 1){
     while ($row = mysql_fetch_array($queryRes)) {
       $emparray[]= $row;
     }
    print json_encode($emparray);
  }
}

//4
function makeExam($title,$description,$difficulty,$questions,$points){
  $query = "INSERT INTO `exams` VALUES (id,'$title','$description','$difficulty','$questions','$points')";
	( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );

	if(mysql_num_rows ($queryRes) >= 1){
    $row = mysql_fetch_array($queryRes);
    print json_encode($row);
  }
}

//5
function getExams(){
  $query = "SELECT * FROM exams";
	( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );
  $emparray = array();
	if(mysql_num_rows ($queryRes) >= 1){
     while ($row = mysql_fetch_array($queryRes)) {
       $emparray[]= $row;
     }
    print json_encode($emparray);
  }
}

//6
function getTakeExam($id){
  $query = "SELECT * FROM exams WHERE id='$id'";
	( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );
  $emparray = array();
	if(mysql_num_rows ($queryRes) >= 1){
     while ($row = mysql_fetch_array($queryRes)) {
       $emparray[]= $row;
     }
    print json_encode($emparray);
  }
}

//7
function getQuestion($ids){
  $idArr = explode(",",$ids);
  $query = "SELECT * FROM questions WHERE id='$idArr[0]'";
  for($i=1; $i < sizeof($idArr); $i++){
    $query.= " OR id='$idArr[$i]'";
  }
	( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );
  $emparray = array();
	if(mysql_num_rows ($queryRes) >= 1){
     while ($row = mysql_fetch_array($queryRes)) {
       $emparray[]= $row;
     }
    print json_encode($emparray);
  }
}

//8
function answerQuestion($user,$exam,$question,$correct,$answer,$cases){
  $query = "INSERT INTO `answers` VALUES ('$exam','$question','$answer','$correct','$user','$cases')";
 ( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );

 if(mysql_num_rows ($queryRes) >= 1){
    $row = mysql_fetch_array($queryRes);
    print json_encode($row);
  }
}

//9
function getExamsAnswered(){
  $query = "SELECT DISTINCT a.exam, a.username, b.title FROM answers a,exams b WHERE a.exam = b.id AND (a.exam NOT IN (SELECT grades.exam FROM grades WHERE grades.username = a.username)) ";
  ( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );
  $emparray = array();
  if(mysql_num_rows ($queryRes) >= 1){
     while ($row = mysql_fetch_array($queryRes)) {
       $emparray[]= $row;
     }
    print json_encode($emparray);
  }

}

//10
function getCountQuestions($user,$exam){
$query = "SELECT * FROM answers WHERE username='$user' AND exam='$exam'";
( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );
print mysql_num_rows ($queryRes);
}

//11
function getCorrectQuestions($user,$exam){
$query = "SELECT SUM(correct) AS correct FROM answers WHERE username='$user' AND exam='$exam'";
 ( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );
	if(mysql_num_rows ($queryRes) >= 1){
   $row = mysql_fetch_array($queryRes);
    echo $row["correct"];
  }
}

//12
function insertGrades($exam,$username,$grade,$feedback){
 $query = "INSERT INTO grades VALUES ('$exam','$username','$grade','$feedback','1')";
 ( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );

 if(mysql_num_rows ($queryRes) >= 1){
    $row = mysql_fetch_array($queryRes);
    print json_encode($row);
  }
}

//13
function getExamResult($username){
 $query = "SELECT * FROM grades,exams WHERE grades.exam = exams.id and username='$username' and state='1'";
 ( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );

 $emparray = array();
  if(mysql_num_rows ($queryRes) >= 1){
     while ($row = mysql_fetch_array($queryRes)) {
       $emparray[]= $row;
     }
    print json_encode($emparray);
  }
}

//14
function getPickExam($user){
  $query = "SELECT DISTINCT answers.exam FROM answers,exams WHERE username='$user'";
  ( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );
  $emparray = array();
  if(mysql_num_rows ($queryRes) >= 1){
     while ($row = mysql_fetch_array($queryRes)) {
       $emparray[]= $row;
     }
    print json_encode($emparray);
  }
}

//15
function getAnsweredQuestions($user,$exam){
  $query = "SELECT * FROM answers WHERE exam='$exam' AND username='$user'";
  ( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );
  $emparray = array();
  if(mysql_num_rows ($queryRes) >= 1){
     while ($row = mysql_fetch_array($queryRes)) {
       $emparray[]= $row;
     }
    print json_encode($emparray);
  }
}

//16
function updateQuestionGrade($user,$exam,$question,$grade){
  $query = "UPDATE answers SET correct='$grade' WHERE exam='$exam' AND username='$user' AND question='$question'";
  ( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );

  if(mysql_num_rows ($queryRes) >= 1){
     $row = mysql_fetch_array($queryRes);
     print json_encode($row);
   }
}
mysql_close($dbh);
exit();
?>