<html>
<head>
</head>
<body>
<h1> MODIFICATION D'UN COMPTE (ETAPE 2)</h1>

<?php
 
session_start();


//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if(empty($_POST['modify'])) {
	
	header("Location: index.php");
	Exit;	
}
//otherwise we get the login values to modify
else{
	$login = $_POST['login_field'];
	
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
		$file_db->setAttribute(PDO::ATTR_ERRMODE, 
			    	PDO::ERRMODE_EXCEPTION); 





		/**************************************
		* get values of the account           *
		**************************************/


		$result =  $file_db->query("SELECT * FROM personnes WHERE login = '$login'");

		foreach($result as $row) {
			$admin = $row['admin'];
			$mdp = $row['mdp'];
			$actif = $row['actif'];
		}



		/**************************************
		* set the form with those values      *
		**************************************/

		//if the login to modify does not exist
		if(empty($mdp)){

			echo "	<h2 style='color:red'>Le login n'existe pas!</h2>
				<form method='post' action='modify_account.php'>
				<input type='submit' name='modify_account' value='recommencer'/>
				</form>";
		}
		else{

		echo "	<form method='post' action='modifying.php'>
			<fieldset><legend>login : </legend>
				<input type='text' name='login_field' value='$login' readonly/>
			</fieldset>
			<fieldset><legend>Mot de passe : </legend>
				<input type='password' name='pwd_field' value='$mdp' required/>
			</fieldset>
			<fieldset><legend>Validité : </legend>";

			//if the account is actif
			if($actif == "actif"){

				echo "
				<input type='radio' name='activity_field' value='actif' required checked/>active
				<input type='radio' name='activity_field' value='inactif' required/>inactive";

			}
			//otherwise inactif			
			else{

				echo "
				<input type='radio' name='activity_field' value='actif' required/>active
				<input type='radio' name='activity_field' value='inactif' required checked/>inactive";

			}

			echo "
			</fieldset>
			<fieldset><legend>Rôle : </legend>";

			//if the account is admin
			if($admin == "admin"){

				echo "
				<input type='radio' name='role_field' value='admin' required checked/>admin
				<input type='radio' name='role_field' value='user' required/>user";

			}
			//otherwise user			
			else{

				echo "
				<input type='radio' name='role_field' value='admin' required/>admin
				<input type='radio' name='role_field' value='user' required checked/>user";

			}

		echo "	</fieldset>
			<input type='submit' name='modify_steptwo' value='modifier'/>
			</form>
			<form method='post' action='modify_account.php'>
			<input type='submit' name='modify_account' value='retour'/>
			</form>";
		}




		/**************************************
		* Close db connections                *
		**************************************/

		// Close file db connection
		$file_db = null;
	}
	catch(PDOException $e) {
		// Print PDOException message
		echo $e->getMessage();
	}

}


?>









</body>
</html>


