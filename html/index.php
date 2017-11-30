<html>
<head></head>
<body>
<h1>PAGE LOGIN</h1>
<?php

/**************************************
* session management                  *
**************************************/
session_start();

//if the user is already connected
if($_SESSION['loggedin']){
	header('Location: userorientation.php');
}

//if bad loggin, then show alert message and destroy the sessions
if(isset($_SESSION['logginfail']) && $_SESSION['logginfail']){

	if(session_destroy()){
		echo '<script type="text/javascript">alert("loggin refusé!")</script>';	
	}
}
?>




<form method="post" action="connect.php">
<fieldset><legend>Login : </legend><input type="text" name="login"/></fieldset>
<fieldset><legend>Mot de passe : </legend><input type="password" name="motdepasse"/></fieldset>
<input type="submit" name="submit" value="Se connecter"/>
</form>




</body>
</html>
