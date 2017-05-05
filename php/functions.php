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
        $qu = str_replace("+","\+",$q);
        $ca = str_replace("+","\+",$c);
        makeQuestion($qu,$d,$ca);
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
        $a = mysql_real_escape_string($_POST["answer"]);
        $answer = str_replace("+","\+",$a);
        $cases = mysql_real_escape_string($_POST["cases"]);
        $log = mysql_real_escape_string($_POST["log"]);        
        answerQuestion($user,$examID,$question,$correct,$answer,$cases,$log);
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
  case 17:
        $id = mysql_real_escape_string($_POST["questions"]);
        getSpecQuestion($id);
        break;
    case 20:
        $in = mysql_real_escape_string($_POST["in"]);
        test($in);
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
function answerQuestion($user,$exam,$question,$correct,$answer,$cases,$log){
  $query = "INSERT INTO `answers` VALUES ('$exam','$question','$answer','$correct','$user','$cases','','$log')";
  $query2 = "UPDATE `answers` a, `exams` e SET a.Points = e.Points WHERE e.id = a.exam";
  $query3 = "UPDATE `answers` a, `questions` q SET a.case1 = q.case1 WHERE q.id = a.question";

 ( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );
 ( $queryRes1 = mysql_query ( $query2 ) ) or die ( mysql_error() );
 ( $queryRes2 = mysql_query ( $query3 ) ) or die ( mysql_error() );
 if(mysql_num_rows ($queryRes2) >= 1){
    $row3 = mysql_fetch_array($queryRes2);
  } 
 if(mysql_num_rows ($queryRes1) >= 1){
    $row2 = mysql_fetch_array($queryRes1);
  } 
 if(mysql_num_rows ($queryRes) >= 1){
    $row = mysql_fetch_array($queryRes);
    print json_encode($row);
  }
}

//9
function getExamsAnswered(){
  $query = "SELECT DISTINCT a.exam, a.username, b.title FROM answers a,exams b WHERE a.exam = b.id AND (a.exam NOT IN (SELECT grades.exam FROM grades WHERE grades.username = a.username))";
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
 $query = "INSERT INTO grades VALUES ('$exam','$username','$grade','$feedback','')";
 $query2 = "UPDATE `grades` a, `exams` e SET a.title = e.title WHERE e.id = a.exam";
 ( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );
 ( $queryRes1 = mysql_query ( $query2 ) ) or die ( mysql_error() );
 if(mysql_num_rows ($queryRes1) >= 1){
    $row2 = mysql_fetch_array($queryRes1);
  } 
 if(mysql_num_rows ($queryRes) >= 1){
    $row = mysql_fetch_array($queryRes);
    print json_encode($row);
  }
}

//13
function getExamResult($username){
 $query = "SELECT * FROM grades WHERE username='$username'";
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

//17
function getSpecQuestion($id){
  $query = "SELECT * FROM questions WHERE id='$id'";
	( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );
  $emparray = array();
	if(mysql_num_rows ($queryRes) >= 1){
     while ($row = mysql_fetch_array($queryRes)) {
       $emparray[]= $row;
     }
    print json_encode($emparray);
  }
}

//20 - tst
function test($in)
{
 $query = "INSERT INTO test VALUES ('$in')";
 ( $queryRes = mysql_query ( $query ) ) or die ( mysql_error() );
 if(mysql_num_rows ($queryRes) >= 1){
    $row = mysql_fetch_array($queryRes);
    print json_encode($row);
  }
}
mysql_close($dbh);
exit();
?>