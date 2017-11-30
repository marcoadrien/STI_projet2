
<?php
session_start();

//if someone try to access directly this page without logging (it means there are empty datas), we redirect
if((empty($_POST['login']) || empty($_POST['motdepasse'])) && empty($_SESSION['loggedin'])) {
	$_SESSION['loggedin'] = false;
	header('Location: index.php');
	Exit;
}

if($_SESSION['admin'] == "admin"){
	header('Location: admin.php');
	Exit;
}
else{
	header('Location: user.php');
	Exit;
}
?>

