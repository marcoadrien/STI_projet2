
<?php

/**************************************
* redirect to index.php if bad session
**************************************/
session_start();


//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if(empty($_POST['send'])) {

	header("Location: index.php");
	Exit;
	
}
//otherwise we verify there is a value for the mail receptor (we do no check if it is a real mail address)
else{
	//if there is a value for the receptor of the mail, we send the message
	if(!empty($_POST['destinataire'])){

		//indicates we arrived from the new message form
		$_SESSION['from_new_message_form'] = true;
		$_SESSION['destinataire'] = $_POST['destinataire'];
		$_SESSION['sujet'] = $_POST['sujet'];
		$_SESSION['message'] = $_POST['message'];

		header("Location: sending.php");
		Exit;

	}
	//otherwise, we redirect again to the form
	else{
		//we can go directly write a new message
		$_SESSION['write_again_message'] = true;
		header("Location: new_message.php");
		Exit;
	}
	
	
}

?>
