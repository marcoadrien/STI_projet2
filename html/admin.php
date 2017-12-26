<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
//this script gets the name of the clicked button (that corresponds to the id message)
//and send it to the detail.php page by the get method
$(document).ready(function(){
    $(".selecter").click(function(){
	var id_message = $(this).attr("name");
	$(location).attr('href', '/detail.php?id_message='+id_message);
    });
});
</script>
</head>
<body>
<h1>PAGE ADMIN</h1>
<?php
session_start();


//if the pwd must be changed again
if($_SESSION['change_again_pwd']){
	header("Location: change_pwd.php");
	Exit;
}

//if the user is already connected but try to access this page without beeing admin
if($_SESSION['admin'] != "admin"){
	header("Location: userorientation.php");
	Exit;
}


//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if((empty($_POST['login']) || empty($_POST['motdepasse'])) && empty($_SESSION['loggedin'])) {
	$_SESSION['loggedin'] = false;
	header('Location: index.php');
	Exit;
}

//current session user
$login = $_SESSION['username']; 



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
	* print messages
	**************************************/

	//prepared statement against sql injections
	$result = $file_db->prepare('SELECT * FROM messages WHERE receptor = :login ORDER BY date ASC');
	$result->execute(array('login' => $login));

	//$result =  $file_db->query("SELECT * FROM messages WHERE receptor = '$login' ORDER BY date ASC");

	echo "<table style = 'border-spacing: 20px;width:100%'><tr><td>Actions</td><td>Date</td><td>Expéditeur</td><td>Sujet</td></tr>";
	

	foreach($result as $row) {

	
		echo "<tr><td><button name='" . $row['message_id'] . "' class='selecter'>ouvrir</button></td><td>" . $row['date'] . "</td><td>" . $row['expeditor'] . "</td><td>" . $row['subject'] . "</td></tr>";		
		
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

<form method="post" action="change_pwd.php">
<input type="submit" name="change_pwd" value="changer mot de passe"/>
</form>

<form method="post" action="logout.php">
<input id = "btnLogout" type="submit" name="btnLogout" value="se déconnecter"/>
</form>

<form method="post" action="new_message.php">
<input type="submit" name="new_message" value="nouveau message"/>
</form>


<form method="post" action="account_gestion.php">
<input type="submit" name="account_gestion" value="gérer les comptes"/>
</form>

</body>
</html>
