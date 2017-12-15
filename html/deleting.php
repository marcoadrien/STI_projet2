
<?php

/**************************************
* redirect to index.php if bad session
**************************************/
session_start();

//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if(empty($_POST['delete'])) {

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
//otherwise we delete the account
else{
	//we get the id of the message to delete
	$login = $_POST['login_field']; 
	
	//if the value is missing we redirect ahgain to the form
	if(empty($_POST['login_field'])){
		$_SESSION['from_delete_form_again'] = true;
		header('Location: delete_account.php');
		Exit;
	}
	//otherwise we can make the job
	else{
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
			* delete account in database
			**************************************/

			$file_db->exec("DELETE FROM personnes WHERE login = '$login'");

			/**************************************
			* Close connections                *
			**************************************/

			// Close file db connection
			$file_db = null;
		
			header('Location: userorientation.php');
			Exit;

		
		}
		catch(PDOException $e) {
			// Print PDOException message
			echo $e->getMessage();
		} 
	} 


}

?>

