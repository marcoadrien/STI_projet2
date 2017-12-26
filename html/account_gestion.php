<html>
<head>
</head>
<body>
<h1>GESTION DES COMPTES</h1>
<br/>
<h2>COMPTES EXISTANTS:</h2>
<?php
session_start();


//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if(empty($_POST['account_gestion'])) {
	header('Location: index.php');
	Exit;
}
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
	    $file_db->setAttribute(PDO::ATTR_ERRMODE, 
		                    PDO::ERRMODE_EXCEPTION); 
	 
	    
	 
	   
	 
	    /**************************************
	    * show tables to debug                *
	    **************************************/
	 

	    $result =  $file_db->query('SELECT * FROM personnes');
	
	    foreach($result as $row) {
	      echo "Login: " . $row['login'] . "<br/>";
	      echo "Rôle: " . $row['admin'] . "<br/>";
	      echo "Mdp: " . $row['mdp'] . "<br/>";
	      echo "Validité: " . $row['actif'] . "<br/>";
	      echo "<br/>";
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

<form method="post" action="delete_account.php">
<input type="submit" name="delete_account" value="supprimer compte"/>
</form>

<form method="post" action="create_account.php">
<input type="submit" name="create_account" value="créer compte"/>
</form>

<form method="post" action="modify_account.php">
<input type="submit" name="modify_account" value="modifier compte"/>
</form>


<form method='post' action='admin.php'>
<input type='submit' name='account_gestion' value='retour'/>
</form>

</body>
</html>
