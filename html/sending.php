
<?php

/**************************************
* redirect to index.php if bad session
**************************************/
session_start();

//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if(empty($_POST['sujet']) || empty($_POST['message'])) {

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
//otherwise we send the message
else{

	$receptor = $_POST['destinataire'];	

	//we set the receptor of the message if the sending is 
	//just an answer to a message and not a new message
	if(empty($_POST['destinataire'])){
		$receptor = $_SESSION['expeditor'];
	}

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
		* write message in database
		**************************************/

		$file_db->exec("INSERT INTO messages (receptor, expeditor, subject, message) 
                            VALUES ('{$receptor}', '{$_SESSION['username']}', '{$_POST['sujet']}', '{$_POST['message']}')");

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

