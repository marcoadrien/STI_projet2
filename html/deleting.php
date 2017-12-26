
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

	//we remove all the special characters to prevent from script injections
	$_POST['login_field'] = strip_tags($_POST['login_field']);
	$_POST['pwd_field'] = strip_tags($_POST['pwd_field']);

	//we get the id of the message to delete
	$login = $_POST['login_field']; 
	$pwd = $_POST['pwd_field']; 
	
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
			//disable emulated prepared statements to get real prepared statements
			$file_db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			// Set errormode to exceptions
			$file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 




			
			/**************************************
			* get values of the account           *
			**************************************/

			$hashed_input = hash('sha256', $pwd);

			//prepared statement against sql injections
			$result = $file_db->prepare('SELECT * FROM personnes WHERE login = :login AND mdp = :mdp');
			$result->execute(array('login' => $login, 'mdp' => $hashed_input));

			//$result =  $file_db->query("SELECT * FROM personnes WHERE login = '$login' AND mdp = '$hashed_input'");

			foreach($result as $row) {
				$admin = $row['admin'];
				$mdp = $row['mdp'];
				$actif = $row['actif'];
			}
			
			//if bad loggin
			if($hashed_input != $mdp){
				$_SESSION['from_delete_form_again'] = true;
				header('Location: delete_account.php');
				Exit;
			}
			else{

				/**************************************
				* delete account in database
				**************************************/

				$result = $file_db->prepare("DELETE FROM personnes WHERE login = :login");
				$result->execute(array('login' => $login));

				/**************************************
				* Close connections                *
				**************************************/

				// Close file db connection
				$file_db = null;
		
				header('Location: userorientation.php');
				Exit;
			}

		
		}
		catch(PDOException $e) {
			// Print PDOException message
			echo $e->getMessage();
		} 
	} 


}

?>

