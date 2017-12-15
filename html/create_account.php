<html>
<head>
</head>
<body>
<h1>CREATION D'UN COMPTE</h1>

<?php
 
session_start();


//if someone try to access directly this page without logging (it means there are empty datas), we redirect

if($_SESSION['do_again_creation_form']){
	//reset
	$_SESSION['do_again_creation_form'] = false;
	echo "Tous les champs doivent être remplis!";
	//we stay on this page!
}
elseif(empty($_POST['create_account'])) {
	
	header("Location: index.php");
	Exit;	
}



?>






<form method="post" action="creating.php">
<fieldset><legend>login : </legend><input type="text" name="login_field"/></fieldset>
<fieldset><legend>Mot de passe : </legend><input type="password" name="pwd_field"/></fieldset>
<fieldset><legend>Validité : </legend>
	<input type="radio" name="activity_field" value="actif"/>active
	<input type="radio" name="activity_field" value="inactif"/>inactive
</fieldset>
<fieldset><legend>Rôle : </legend>
	<input type="radio" name="role_field" value="admin"/>admin
	<input type="radio" name="role_field" value="user"/>user
</fieldset>
<input type="submit" name="create" value="créer"/>
</form>



<form method='post' action='account_gestion.php'>
<input type='submit' name='account_gestion' value='retour'/>
</form>


</body>
</html>


