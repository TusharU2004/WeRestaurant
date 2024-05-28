<?php session_start();

	if(empty($_POST)) { header("location: index.php"); exit; }

	$errors = array();

	if(empty($_POST["username"]))
		$errors[] = "Username was empty.";
	if(empty($_POST["password"]))
		$errors[] = "Password was empty.";

	if( ! empty($errors)) {
		echo "Error(s):<hr />";
		foreach($errors as $e)
		{
			echo $e."<br>";
		}
		exit;
	}


	if($_POST["username"] == 'admin' && $_POST["password"] == 'admin')
	{
		$_SESSION["adid"] = 1;
		$_SESSION["adnm"] = 'Admin';

		header("location: index.php");
	}
	else
	{
		echo "Invalid Username/Password. Please try again.";
	}
?>
