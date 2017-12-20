
<?php

/**************************************
* redirect to index.php if bad session
**************************************/
session_start();


//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if(empty($_POST['modify_steptwo'])) {

	header("Location: index.php");
	Exit;
	
}
//otherwise we modify the account
else{
	//if an input is missing, we redirect to the form
	if(empty($_POST['pwd_field']) || (($_POST['activity_field'] != "actif" )&& ($_POST['activity_field'] != "inactif")) || (($_POST['role_field'] != "admin" )&& ($_POST['role_field'] != "user"))){
		
		//notice that we redirect always to the step one, that must be better
		$_SESSION['get_id_to_modify_again'] = true;
		header("Location: modify_account.php");
		Exit;
	}
	//otherwise, we do the job
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
			* modify account in database
			**************************************/

			$_POST['pwd_field'] = hash('ripemd160', $_POST['pwd_field']);
			
			$file_db->exec("UPDATE personnes SET admin = '{$_POST['role_field']}', mdp = '{$_POST['pwd_field']}', actif = '{$_POST['activity_field']}' WHERE login ='{$_SESSION['login_field']}'");

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


}

?>

