<html>
<head>
</head>
<body>
<h1>REPONDRE AU MESSAGE</h1>

<?php

/**************************************
* redirect to index.php if bad session
**************************************/
session_start();

//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if(empty($_POST['answer_message'])) {

	if($_SESSION['from_answer_message_form']){
		//it is not the first time we arrived here because there is a missing value
		echo "Complétez les champs svp!";
	}
	elseif($_SESSION['loggedin']){
		header('Location: userorientation.php');
		Exit;
	}
	else{
		if(session_destroy()){
			header("Location: index.php");
			Exit;
		}
	}
}

//if we stay on this page, we indicate it for the sending.php
$_SESSION['from_answer_message_form'] = true;


?>


<form method="post" action="sending.php">
<fieldset><legend>Sujet : </legend><input type="text" name="sujet"/></fieldset>
<fieldset><legend>Message : </legend><input  style = "width:100%;" type="text" name="message"/></fieldset>
<input type="submit" name="send" value="envoyer"/>
</form>

<form method="post" action="userorientation.php">
<input type="submit" name="retour" value="retour"/>
</form>

</body>
</html>
