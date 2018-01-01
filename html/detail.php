<html>
<head>
</head>
<body>
<h1>DETAIL DU MESSAGE</h1>

<?php
 
session_start();


//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if(empty($_POST['id_message'])) {

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


//we remove all the special characters to prevent from script injections
$_POST['id_message'] = strip_tags($_POST['id_message']);

//we get the message id to display
$_SESSION['idmsg'] = $_POST['id_message'];
$id = $_SESSION['idmsg'];



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
	* print message
	**************************************/

	//$result =  $file_db->query("SELECT * FROM messages WHERE message_id = '$id'");

	//prepared statement against sql injections
	$result = $file_db->prepare('SELECT * FROM messages WHERE message_id = :id');
	$result->execute(array('id' => $id));

	echo "<table style = 'border-spacing: 20px;width:100%'><tr><td>Date</td><td>Expéditeur</td><td>Sujet</td><td>Message</td></tr>";
	

	foreach($result as $row) {

	
		echo "<tr><td>" . $row['date'] . "</td><td>" . $row['expeditor'] . "</td><td>" . $row['subject'] . "</td><td>" . $row['message'] . "</td></tr>";
				
		$_SESSION['expeditor'] = $row['expeditor'];
	}
	
	echo "</table>";


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



?>


<form method="post" action="answer_message.php">
<input type="submit" name="answer_message" value="répondre au message"/>
</form>

<form method="post" action="delete_message.php">
<input type="submit" name="delete_message" value="supprimer message"/>
</form>

<form method="post" action="userorientation.php">
<input type="submit" name="retour" value="retour"/>
</form>

</body>
</html>


