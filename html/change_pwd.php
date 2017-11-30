<html>
<head>
</head>
<body>
<h1>CHANGEMENT MOT DE PASSE</h1>

<?php
 
session_start();


//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if(empty($_POST['change_pwd'])) {

	header("Location: index.php");
	Exit;
	
}



?>




<form method="post" action="insert_pwd_changed.php">
<fieldset><legend>Nouveau mot de passe : </legend><input type="password" name="new_pwd" required/></fieldset>
<input type="submit" name="send" value="appliquer changement"/>
</form>

<form method="post" action="userorientation.php">
<input type="submit" name="retour" value="retour"/>
</form>


</body>
</html>


