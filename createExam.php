<html>
  <head>
  <style>
    * {
      box-sizing: border-box;
    }
    
    #input {
      margin-bottom: 12px;
    }
    
    #questionsTable {
      border-collapse: collapse;

      border: 1px solid #ddd;
      font-size: 18px;
    }
    
    #questionsTable th, #questionsTable td {
      text-align: left;
      padding: 12px;
    }
    
    #questionsTable tr {
      border-bottom: 1px solid #ddd;
    }
    
    #questionsTable tr.header, #questionsTable tr:hover {
      background-color: #f1f1f1;
    }
</style>
  <title>Create Exam</title>
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
    $json_obj = json_encode(array( "getQuestions" => null ));
    $result = toMID($json_obj);
    $form_data = $result;
    if(isset($_POST['submit']))
    { 
      $json_obj = json_encode(array( "examObject"=> $_POST ));  
      $result = toMID($json_obj);  
      $message = "<pre>Exam created!</pre>";
    } 
  ?> 
  <div class="center">
  <h1 style="font-size:250%;">Create Exam</h1>
  <p><?php echo $message; ?></p>
  <form action="" method="post">  
  <label>Difficulty of Exam: </label>  
  <select name="difficulty" id="diff" required>      
  <option disabled>Select a Difficulty</option>    
  <option value="Easy">Easy</option>    
  <option value="Medium">Medium</option>    
  <option value="Hard">Hard</option>   
  </select>  
  <label>Exam Name: </label>  
  <input id="examName" name="examName" placeholder="Exam Title" required>  
  <label>Exam Description: </label>  
  <input id="examDesc" name="examDesc" placeholder="Description" required>  
   
  <br>
  <br>
  <label>Search Questions: </label>  
  <input type="text" id="input" onkeyup="search()" align="center" placeholder="Search questions..">
  <input type="submit" name="submit" value="Create Exam"> 
  <br>
  <table id="questionsTable" border="1" width="800px" align="center" bgcolor="#FFF">
  <tr><th width="10%">Select</th><th>Question</th><th>Difficulty</th><th>Test Cases (separated by ':')</th><th>Point Value</th></tr></table>
  </form>
  </div>
  <script language="javascript">
    function checkInput(ob) {
      var invalidChars = /[^0-9]/gi;
      if(invalidChars.test(ob.value)) {
      ob.value = ob.value.replace(invalidChars,"");
      }
    }
  </script>
  <script>
    var cnt = 0;
    function createTable(ID, ques, diff, case1)
    {
      var table = document.getElementById("questionsTable");
      var row = table.insertRow(-1);
      var cell1 = row.insertCell(0);
      var cell2 = row.insertCell(1);
      var cell3 = row.insertCell(2);
      var cell4 = row.insertCell(3);
      var cell5 = row.insertCell(4);

      cell1.innerHTML = "<input type='checkbox' name='" + ID + "'>";
      cell2.innerHTML = ques;
      cell3.innerHTML = diff;
      cell4.innerHTML = case1;
      cell5.innerHTML = "<input type='text' id='points' name='points[]' onkeyup='checkInput(this)' placeholder='0'/>";
    }
    function search()
    {
      var input, filter, table, tr, td, td2, i;
      input = document.getElementById("input");
      filter = input.value.toUpperCase();
      table = document.getElementById("questionsTable");
      tr = table.getElementsByTagName("tr");
    
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        td2 = tr[i].getElementsByTagName("td")[2];
        if (td || td2) {
          if (td.innerHTML.toUpperCase().indexOf(filter) > -1 || td2.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        } 
      }
    }
  </script>
  <?php  
    $a = json_decode($form_data,true);  
    $arrayLength = count($a); 
    $x = 0;  
    while($x < $arrayLength)
    {    
      $id = $a[$x]["id"];    
      $ques = $a[$x]["question"];    
      $diff = $a[$x]["difficulty"];    
      $case1 = $a[$x]["case1"];  
      $question = str_replace('"',"'",$ques);
      $caseNoSpace = str_replace(' ', '', $case1);
      $case1 = str_replace('"', "'", $caseNoSpace);
      echo '<script>createTable('.$id.',"'.$question.'","'.$diff.'","'.$case1.'");</script>';       
      $x++;  
    }   
  ?>
  </body>
</html>