
<?php

/**************************************
* redirect to index.php if bad session
**************************************/
session_start();

//if the user is already connected
if($_SESSION['loggedin']){
	header('Location: userorientation.php');
	Exit;
}

//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if(empty($_POST['login']) || empty($_POST['motdepasse'])) {
	$_SESSION['loggedin'] = false;
	$_SESSION['logginfail'] = true;
	header('Location: index.php');
	Exit;
}
//otherwise we analyse the data connection to give acces or not
else{

	$login = $_POST['login'];
	$motdepasse = $_POST['motdepasse'];
	$actif = "actif";
	$admin = "admin";

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
		* give authorisation or not
		**************************************/
		$result =  $file_db->query("SELECT * FROM personnes WHERE login = '$login'");
		
		//we get the good values that match in the DB
		foreach($result as $row) {			
			$mdptocompare = $row['mdp'];
			$actiftocompare = $row['actif'];
			$admintocompare = $row['admin'];
		}
		//accepted, good loggin
		$hashed_input = hash('ripemd160', $motdepasse);
		if(($hashed_input == $mdptocompare) && !empty($motdepasse) && ($actiftocompare == $actif)){
			$_SESSION['loggedin'] = true;
			$_SESSION['logginfail'] = false;
			//we want to know if it is an admin or not
			//if it is an admin
			if($admintocompare == $admin){
				$_SESSION['admin'] = "admin";
			}
			//it is a user
			else{
				$_SESSION['admin'] = "user";
			}
			// Close file db connection
			$file_db = null;

			//we save the user name
			$_SESSION['username'] = $login;

			header('Location: userorientation.php');
			Exit;		
		}
		//not accepted, bad loggin
		else{
			$_SESSION['loggedin'] = false;
			$_SESSION['logginfail'] = true;
			// Close file db connection
			$file_db = null;
			header('Location: index.php');
			Exit;
		}


		
	}
	catch(PDOException $e) {
	// Print PDOException message
	echo $e->getMessage();
	}  


}

?>

