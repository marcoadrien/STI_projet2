<html>
<head>
</head>
<body>
<h1>SUPPRESSION D'UN COMPE</h1>

<?php
 
session_start();


//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if(empty($_POST['delete_account'])) {
	
	header("Location: index.php");
	Exit;	
}



?>






<form method="post" action="deleting.php">
<fieldset><legend>login à supprimer: </legend><input type="text" name="login_field" required/></fieldset>
<input type="submit" name="delete" value="supprimer"/>
</form>



<form method='post' action='account_gestion.php'>
<input type='submit' name='account_gestion' value='retour'/>
</form>


</body>
</html>


