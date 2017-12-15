
<?php

/**************************************
* redirect to index.php if bad session
**************************************/
session_start();

//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if(empty($_POST['new_pwd'])) {

	if($_SESSION['loggedin']){
		//we are going to be redirected directly to the change of password again
		$_SESSION['change_again_pwd'] = true;
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
//otherwise we change the password
else{

	//we save the login name
	$id = $_SESSION['username'];
	//we save the new pwd
	$new_pwd = $_POST['new_pwd'];

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
		* change pwd in database
		**************************************/

		$file_db->exec("UPDATE personnes SET mdp = '$new_pwd' WHERE login = '$id'");

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

