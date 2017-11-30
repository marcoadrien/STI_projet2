<html>
<head>
</head>
<body>
<h1>MODIFICATION D'UN COMPTE (ETAPE 1)</h1>

<?php
 
session_start();


//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if(empty($_POST['modify_account'])) {
	
	header("Location: index.php");
	Exit;	
}



?>





<form method="post" action="modify_account_steptwo.php">
<fieldset><legend>login à modifier: </legend><input type="text" name="login_field" required/></fieldset>
<input type="submit" name="modify" value="modifier"/>
</form>



<form method='post' action='account_gestion.php'>
<input type='submit' name='account_gestion' value='retour'/>
</form>



</body>
</html>


