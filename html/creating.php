
<?php

/**************************************
* redirect to index.php if bad session
**************************************/
session_start();


//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if(empty($_POST['create'])) {

	header("Location: index.php");
	Exit;
	
}
//otherwise we create the account if the password is fine
else{
	//if one of the values is missing, we redirect again to the form
	//we will put explicit messages if we have time at the end of he project
	if(empty($_POST['login_field']) ||
	empty($_POST['role_field']) || 
	empty($_POST['pwd_field']) || 
	empty($_POST['activity_field'])){
		
		$_SESSION['do_again_creation_form'] = true;
		header("Location: create_account.php");
		Exit;
	}



	//we remove all the special characters to prevent from script injections
	$_POST['login_field'] = strip_tags($_POST['login_field']);
	$_POST['role_field'] = strip_tags($_POST['role_field']);
	$_POST['pwd_field'] = strip_tags($_POST['pwd_field']);
	$_POST['activity_field'] = strip_tags($_POST['activity_field']);


	//if the password is fine, we create the account		
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
			* write account in database
			**************************************/

			$_POST['pwd_field'] = hash('sha256', $_POST['pwd_field']);



			//prepared statement against sql injections
			$result = $file_db->prepare('INSERT INTO personnes (login, admin, mdp, actif) 
		                    VALUES (:login_field, :role_field, :pwd_field, :activity_field)');
			$result->execute(array('login_field' => $_POST['login_field'], 'role_field' => $_POST['role_field'], 'pwd_field' => $_POST['pwd_field'], 'activity_field' => $_POST['activity_field']));



			//$file_db->exec("INSERT INTO personnes (login, admin, mdp, actif) 
		                 //   VALUES ('{$_POST['login_field']}', '{$_POST['role_field']}', '{$_POST['pwd_field']}', '{$_POST['activity_field']}')");

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
			echo "<h2 style='color:red'>Traduction: Login déjà utilisé!</h2>";
			echo "
			<form method='post' action='create_account.php'>
			<input type='submit' name='create_account' value='recommencer'/>
			</form>";
		} 
	}
	//otherwise, the password must be better
	else {
		$_SESSION['do_again_creation_form'] = true;
		header("Location: create_account.php");
		Exit;
	}

 


}

?>

