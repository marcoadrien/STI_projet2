<html>
<head>
</head>
<body>
<h1>GESTION DES COMPTES</h1>
<br/>
<?php
session_start();


//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if(empty($_POST['account_gestion'])) {
	header('Location: index.php');
	Exit;
}

?>

<form method="post" action="delete_account.php">
<input type="submit" name="delete_account" value="supprimer compte"/>
</form>

<form method="post" action="create_account.php">
<input type="submit" name="create_account" value="créer compte"/>
</form>

<form method="post" action="modify_account.php">
<input type="submit" name="modify_account" value="modifier compte"/>
</form>


<form method='post' action='admin.php'>
<input type='submit' name='account_gestion' value='retour'/>
</form>

</body>
</html>
