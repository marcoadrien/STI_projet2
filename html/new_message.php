<html>
<head>
</head>
<body>
<h1>NOUVEAU MESSAGE</h1>

<?php
 
session_start();


//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if($_SESSION['write_again_message']){
	//we are allowed to stay on this page because me have made a bad input
	//reset
	$_SESSION['write_again_message'] = false;
	echo "Il faut saisir un destinataire!";
}
elseif(empty($_POST['new_message'])) {
	//we are not allowed to stay on this page
	header("Location: index.php");
	Exit;
	
}



?>




<form method="post" action="mail_receptor_verification.php">
<fieldset><legend>Destinataire : </legend><input type="text" name="destinataire"/></fieldset>
<fieldset><legend>Sujet : </legend><input type="text" name="sujet"/></fieldset>
<fieldset><legend>Message : </legend><input  style = "width:100%;" type="text" name="message"/></fieldset>
<input type="submit" name="send" value="envoyer"/>
</form>


<form method="post" action="userorientation.php">
<input type="submit" name="retour" value="retour"/>
</form>


</body>
</html>


