<html>
<head>
</head>
<body>
<h1>MODIFICATION D'UN COMPTE (ETAPE 1)</h1>

<?php
 
session_start();


//if someone try to access directly this page without logging (it means there are empty datas), we redirect

if($_SESSION['get_id_to_modify_again']){
	//reset
	$_SESSION['get_id_to_modify_again'] = false;
	echo "Il faut remplir tous les champs pour les deux étapes et le mot de passe doit être suffisament fort (8 caractères majuscules et minuscules avec chiffres)!";
}
elseif(empty($_POST['modify_account'])) {
	
	header("Location: index.php");
	Exit;	
}



?>





<form method="post" action="modify_account_steptwo.php">
<fieldset><legend>login à modifier: </legend><input type="text" name="login_field"/></fieldset>
<fieldset><legend>mot de passe du compte à modifier: </legend><input type="password" name="pwd_field"/></fieldset>
<input type="submit" name="modify" value="modifier"/>
</form>



<form method='post' action='account_gestion.php'>
<input type='submit' name='account_gestion' value='retour'/>
</form>



</body>
</html>


