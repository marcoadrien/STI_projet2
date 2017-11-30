
<?php

/**************************************
* redirect to index.php if bad session
**************************************/
session_start();

//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if(empty($_POST['delete_message'])) {

	if($_SESSION['loggedin']){
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
//otherwise we delete the message
else{
	//we get the id of the message to delete
	$id = $_SESSION['idmsg']; 
	/*echo "id message: ";
	echo $id;*/


	// Set default timezone
  	date_default_timezone_set('UTC');
 
	try {
		/**************************************
		* Create databases and                *
		* open connections                    *
		**************************************/

		// Create (connect to) SQLite database in file
		$file_db = new PDO('sqlite:/var/www/databases/database.sqlite');
		// Set errormode to exceptions
		$file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 


		/**************************************
		* delete message in database
		**************************************/

		$file_db->exec("DELETE FROM messages WHERE message_id = '$id'");

		/**************************************
		* Close connections                *
		**************************************/

		// Close file db connection
		$file_db = null;
		
		header('Location: userorientation.php');


		
	}
	catch(PDOException $e) {
	// Print PDOException message
	echo $e->getMessage();
	}  


}

?>

