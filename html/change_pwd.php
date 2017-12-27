<html>
<head>
</head>
<body>
<h1>CHANGEMENT MOT DE PASSE</h1>

<?php
 
session_start();


//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if($_SESSION['change_again_pwd']){
	//we reset the value and stay on this page
	$_SESSION['change_again_pwd'] = false;
	echo "Il faut remplir tous les champs et mettre le bon ancien mot de passe! Mettre aussi un nouveau mot de passe de 8 caractères minimum avec majuscules ou minuscules et des chiffres.";
}
elseif(empty($_POST['change_pwd'])) {
	//redirection, not allowed to be on this page
	header("Location: index.php");
	Exit;
	
}



?>




<form method="post" action="insert_pwd_changed.php">
<fieldset><legend>Ancien mot de passe : </legend><input type="password" name="old_pwd"/></fieldset>
<fieldset><legend>Nouveau mot de passe : </legend><input type="password" name="new_pwd"/></fieldset>
<input type="submit" name="send" value="appliquer changement"/>
</form>

<form method="post" action="userorientation.php">
<input type="submit" name="retour" value="retour"/>
</form>


</body>
</html>


