<?php

function auth($role)
{  
  if($role != "professor" && $role != "student")
  {      
    echo "Please log in<br>";        
    echo '<a href="index.php">Log In</a><br>';        
    exit();    
  }
}

function authProf($role)
{  
  if($role != "professor")
  {    
  echo "You do not have access to this page.<br>";    
  echo '<a href="home.php">Home Page</a><br>';    
  exit();  
  }
}

function nav($role)
{  
  $out = '<ul><li><a href="home.php">Home</a></li> ';
    
  if($role == "student")
  {      
    $out .= '<li><a href="pickExam.php">Take Exam</a></li>  ';        
    $out .= '<li><a href="viewGrade.php">View Grades</a> </li>';    
  }
  else
  {      
    $out .= '<li><a href="createExam.php">Create Exams</a> </li> ';      
    $out .= '<li><a href="createQuestion.php">Create Questions</a> </li> ';      
    $out .= '<li><a href="gradeExam.php">Grade Exams</a> </li> ';    
  }
  
  $out .= '<li><a href="index.php">Log Out</a></li></ul><br>';    
  echo $out;
}

function toMID($json_obj)
{  
  $ch = curl_init('https://web.njit.edu/~kkc22/CS490proj/print.php');    
  curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_obj );    
  curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));    
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );    
  $result = curl_exec($ch);    
  curl_close($ch);  
  return $result;
}
?>
