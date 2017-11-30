<html>
<head>
</head>
<body>
<h1>NOUVEAU MESSAGE</h1>

<?php
 
session_start();


//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if(empty($_POST['new_message'])) {

	header("Location: index.php");
	Exit;
	
}



?>




<form method="post" action="sending.php">
<fieldset><legend>Destinataire : </legend><input type="text" name="destinataire" required/></fieldset>
<fieldset><legend>Sujet : </legend><input type="text" name="sujet" required/></fieldset>
<fieldset><legend>Message : </legend><input  style = "width:100%;" type="text" name="message" required/></fieldset>
<input type="submit" name="send" value="envoyer"/>
</form>


<form method="post" action="userorientation.php">
<input type="submit" name="retour" value="retour"/>
</form>


</body>
</html>


