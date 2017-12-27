
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
	if(empty($_POST['pwd_field']) || empty($_POST['new_login_field']) || (($_POST['activity_field'] != "actif" )&& ($_POST['activity_field'] != "inactif")) || (($_POST['role_field'] != "admin" )&& ($_POST['role_field'] != "user"))){
		
		//notice that we redirect always to the step one, that must be better
		$_SESSION['get_id_to_modify_again'] = true;
		header("Location: modify_account.php");
		Exit;
	}
	//otherwise, we do the job
	else{


		//we remove all the special characters to prevent from script injections
		$_POST['role_field'] = strip_tags($_POST['role_field']);
		$_POST['pwd_field'] = strip_tags($_POST['pwd_field']);
		$_POST['activity_field'] = strip_tags($_POST['activity_field']);
		$_POST['login_field'] = strip_tags($_POST['login_field']);
		$_POST['new_login_field'] = strip_tags($_POST['new_login_field']);


		//if the password is fine, we modify the account		
		if(trim($_POST['pwd_field'], 'a..z') != '' && trim($_POST['pwd_field'], 'A..Z') != '' && strlen($_POST['pwd_field']) >= 8 && preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $_POST['pwd_field']) && strtolower($_POST['pwd_field']) != $_POST['pwd_field']){

			// Set default timezone
		  	date_default_timezone_set('UTC');
		 
			try {
				/**************************************
				* Create databases and                *
				* open connections                    *
				**************************************/
				// Create (connect to) SQLite database in file
				$file_db = new PDO('sqlite:/var/www/databases/database.sqlite');
				//disable emulated prepared statements to get real prepared statements
				$file_db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				// Set errormode to exceptions
				$file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 


				/**************************************
				* modify account in database
				**************************************/

				$_POST['pwd_field'] = hash('sha256', $_POST['pwd_field']);

				//prepared statement against sql injections
				$result = $file_db->prepare('UPDATE personnes SET login = :new_login_field, admin = :role_field, mdp = :pwd_field, actif = :activity_field WHERE login = :login_field');
				$result->execute(array('new_login_field' => $_POST['new_login_field'], 'role_field' => $_POST['role_field'], 'pwd_field' => $_POST['pwd_field'], 'activity_field' => $_POST['activity_field'], 'login_field' => $_SESSION['login_field']));
			
				//$file_db->exec("UPDATE personnes SET admin = '{$_POST['role_field']}', mdp = '{$_POST['pwd_field']}', actif = '{$_POST['activity_field']}' WHERE login ='{$_SESSION['login_field']}'");

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
		//otherwise, the password must be better
		else{
			$_SESSION['get_id_to_modify_again'] = true;
			header("Location: modify_account.php");
			Exit;
		}
	}  


}

?>

