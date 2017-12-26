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

// add by Dany
if(!isset($_SESSION['number'])){
	$_SESSION['number'] = 0;
}

// add by Dany
if($_SESSION['timestamp']){
	
	echo '<script type="text/javascript">alert("Votre compte est désactivé. Veuillez contacter un administrateur!")</script>';
	session_destroy();
}


//if bad loggin, then show alert message and destroy the sessions
if(isset($_SESSION['logginfail']) && $_SESSION['logginfail']){
	//add by Dany
	$_SESSION['number']++;
	echo '<script type="text/javascript">alert("Login refusé!")</script>';	
}



//default session variables:

//indicates if we can go directly change the password or not
$_SESSION['change_again_pwd'] = false;
//indicates if we can go directly write a new message or not
$_SESSION['write_again_message'] = false;
//indicates we arrived from the new message form
$_SESSION['from_new_message_form'] = false;
//indicates we arrived from the answer message form
$_SESSION['from_answer_message_form'] = false;
//indicates the delete account form must be filled again
$_SESSION['from_delete_form_again'] = false;
//indicates the creation form must be filled again
$_SESSION['do_again_creation_form'] = false;
//indicates the modify account (first step or the second step) form must be filled again
$_SESSION['get_id_to_modify_again'] = false;
?>




<form method="post" action="connect.php">
<fieldset><legend>Login : </legend><input type="text" name="login"/></fieldset>
<fieldset><legend>Mot de passe : </legend><input type="password" name="motdepasse"/></fieldset>
<input type="submit" name="submit" value="Se connecter"/>
</form>




</body>
</html>
