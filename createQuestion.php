<html>
<head>
<title>Create Questions</title>
<link rel="stylesheet" href="css/styles.css">
<script type="text/javascript">
    var cnt = 1;

    function addTestCase(){
        cnt++;
        var div = document.getElementById('div_cases');
        var text = document.createElement("textarea");
        var label = document.createElement("Label");
        var br = document.createElement('br');
        var br1 = document.createElement('br');
        var br2 = document.createElement('br');
        text.id = 'frontCases';
        text.name = 'frontCases[]';
        text.style = 'width:400px; height:50px;'; 
        text.placeholder = 'param1,param2,...,paramN,ExpectedResult';
        label.innerHTML = 'Test Case ' + cnt;
        div.appendChild(br);
        div.appendChild(label);
        div.appendChild(br1);
        div.appendChild(text);
        div.appendChild(br2);
    }
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

if(isset($_POST['submit'])){
$json_obj = json_encode(array( "questionObject"=> $_POST ));
$result = toMID($json_obj);
$message = "<pre>Question added!</pre>";
}

?>
<div class="center">
<h1>Create Questions</h1>
<p><?php echo $message; ?></p>
<form action="" method="post">
    <label>Question Difficulty: </label>  
    <select name="difficulty" id="questDiff" required>    
      <option disabled>Select a Difficulty</option>    
      <option value="Easy">Easy</option>    
      <option value="Medium">Medium</option>    
      <option value="Hard">Hard</option>  
    </select>  
    <br>
    <br>  
    <label>Method Name: </label> 
    <br> 
    <textarea id="question" name="question[]" style="width:400px; height:20px;" placeholder="Method name..." required></textarea>  
    <br>
    <br>
    <label>Parameters: </label>  
    <br>
    <textarea id="question" name="question[]" style="width:400px; height:20px;" placeholder="int a, int b,..." required></textarea>  
    <br>
    <br>
    <label>Method Functionality: </label>  
    <br>
    <textarea id="question" name="question[]" style="width:400px; height:100px;" placeholder="This method..." required></textarea>  
    <br>
    <br> 
    <label>Test Case 1: </label> 
    <br>     
    <textarea id="frontCases" name="frontCases[]" style="width:400px; height:50px;" placeholder="param1,param2,...,paramN,ExpectedResult" required></textarea>  
    <br>
    <div id="div_cases"></div>
    <br>
    <br>
    <input type="button" value="Add Test Case" onClick="addTestCase();">
    <input type="submit" name="submit" value="Create Question">
</form>
</div>
</body>
</html>
