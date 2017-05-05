<?php
  session_start();
  $_SESSION = array();
?>
<html>
  <head>  
    <title>CS 490 Project</title>  
    <link rel="stylesheet" href="css/login.css">
  </head>
  <body>
    <div class="login">
      <center>
        <br>
        <legend>CS 490</legend>
        <br>
        <fieldset>
        <br>
        <input type=text id="username" name="username" placeholder="Username" required autofocus>
        <br>
        <br>
        <input type=password name="password" id="password" placeholder="Password" required>
        <br>
        <button class="btn-primary btn-large" type="button" id="login">Login</button>
        <br>
        <br>
        <span id="info" style="color:white"></span>
        </fieldset>
        <br>
        <br>
      </center>
    </div>
      <table id=”bottom_left”>
      <tr>
        <th>Access:</th>
        <th>Username:</th> 
        <th>Password:</th>
      </tr>
      <tr>
        <td>Professor</td>
        <td>prof</td> 
        <td>prof</td>
      </tr>
      <tr>
        <td>Student</td>
        <td>awk8</td> 
        <td>kelson</td>
      </tr>
      <tr>
        <th colspan="3">Created by:</th>
      </tr>
      <tr>
        <td colspan="2">Andrew Kelson</td>
        <td>Front/Back</td>
      </tr>
      <tr>
      <td colspan="2">Kevin Chan</td>
      <td>Middle</td>
      </tr>
    </table>
  </body>
</html>
<script>
  var postbutton = document.getElementById("login");
  postbutton.addEventListener("click", login);
  var checkbox = document.getElementById("checkbox");
  checkbox.addEventListener("click", see);
  function see()
  {	
    see = document.getElementById("checkbox").checked;	
    if(see)
    {		
      document.getElementById("password").type = 'text';	
    }	
    else
    {		
      document.getElementById("password").type = 'password';	
    }
  }
  function login()
  {	
    var http;	
    var browser = navigator.appName;    
    if(browser == "Microsoft Internet Explorer")		
      http = new ActiveXObject("Microsoft.XMLHTTP");    
    else    	
      http = new XMLHttpRequest();  
    http.open("POST" ,"php/login.php",true);	
    http.setRequestHeader("Content-type","application/x-www-form-urlencoded");	
    var user = document.getElementById('username').value;	
    var pass = document.getElementById('password').value;	
    http.onreadystatechange = function() 
    {	  
      if (http.readyState==4)	  	
        if (http.status==200)	  		
          var response = http.responseText;	 	
      if(response == 1)
      {	    		
        document.getElementById("info").innerHTML = "Login Successful. Redirecting to dashboard...";
        window.setTimeout(function(){ window.location = "home.php" },3000);
      }	    	
      else 
      {	    		
        document.getElementById("info").innerHTML = "Invalid Username/Password.";	    	
      }	
    }
    http.send("user="+user+"&pass="+pass);
  }
</script>