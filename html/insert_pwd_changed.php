
<?php

/**************************************
* redirect to index.php if bad session
**************************************/
session_start();

//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if(empty($_POST['new_pwd']) || empty($_POST['old_pwd'])) {

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


	//we remove all the special characters to prevent from script injections
	$_POST['new_pwd'] = strip_tags($_POST['new_pwd']);
	$_POST['old_pwd'] = strip_tags($_POST['old_pwd']);


	//we save the login name
	$id = $_SESSION['username'];
	//we save the new pwd
	$new_pwd = hash('sha256', $_POST['new_pwd']);
	//we get the old pwd
	$old_pwd = hash('sha256', $_POST['old_pwd']);

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
		* get values of the account           *
		**************************************/

		//prepared statement against sql injections
		$result = $file_db->prepare('SELECT * FROM personnes WHERE login = :id AND mdp = :old_pwd');
		$result->execute(array('id' => $id, 'old_pwd' => $old_pwd));

		//$result =  $file_db->query("SELECT * FROM personnes WHERE login = '$id' AND mdp = '$old_pwd'");

		foreach($result as $row) {
			$admin = $row['admin'];
			$mdp = $row['mdp'];
			$actif = $row['actif'];
		}
		
		//if bad loggin
		if($old_pwd != $mdp){
			$_SESSION['change_again_pwd'] = true;
			header('Location: userorientation.php');
			Exit;
		}
		else{

			/**************************************
			* change pwd in database
			**************************************/

			//prepared statement against sql injections
			$result = $file_db->prepare('UPDATE personnes SET mdp = :new_pwd WHERE login = :id');
			$result->execute(array('new_pwd' => $new_pwd, 'id' => $id));

			//$file_db->exec("UPDATE personnes SET mdp = '$new_pwd' WHERE login = '$id'");

			/**************************************
			* Close connections                *
			**************************************/

			// Close file db connection
			$file_db = null;
	
			header('Location: userorientation.php');
		}

	
	}
	catch(PDOException $e) {
	// Print PDOException message
	echo $e->getMessage();
	}  
	


}

?>

