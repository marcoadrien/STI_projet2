<html>
<head>
</head>
<body>
<h1>SUPPRESSION D'UN COMPE</h1>

<?php
 
session_start();


//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if($_SESSION['from_delete_form_again']){
	//we have to stay on this page because the user has to fill again the field correctly
	//notice that we do not check if the user id exists because it is a deleting and nothing will happen in 	//this case => no DB crash
	echo "Il faut saisir un id!";
	//reset for next time
	$_SESSION['from_delete_form_again'] = false;
}
elseif(empty($_POST['delete_account'])) {
	
	header("Location: index.php");
	Exit;	
}



?>






<form method="post" action="deleting.php">
<fieldset><legend>login à supprimer: </legend><input type="text" name="login_field"/></fieldset>
<input type="submit" name="delete" value="supprimer"/>
</form>



<form method='post' action='account_gestion.php'>
<input type='submit' name='account_gestion' value='retour'/>
</form>


</body>
</html>


