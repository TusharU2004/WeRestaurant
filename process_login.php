<?php session_start();
	if(empty($_POST)) { header("location: index.php"); exit; }

	require_once('db.php');

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

	$getUserDetail = mysqli_query($conn, "SELECT * FROM `admin` WHERE `id`='1'");
	$fetchUserDetail = mysqli_fetch_array($getUserDetail);
	$fetchUsername = $fetchUserDetail['username'];
	$fetchPassword = $fetchUserDetail['password'];

	$getUserDetail1 = mysqli_query($conn, "SELECT * FROM `admin` WHERE `id`='2'");
	$fetchUserDetail1 = mysqli_fetch_array($getUserDetail1);
	$fetchUsername1 = $fetchUserDetail1['username'];
	$fetchPassword1 = $fetchUserDetail1['password'];

	if($_POST["username"] == $fetchUsername && md5($_POST["password"]) == $fetchPassword)
	{
		$_SESSION["adid"] = 1;
		$_SESSION["adnm"] = 'Admin';

		header("location: main_page.php");
		// header("location: index.php");
	} elseif($_POST["username"] == $fetchUsername1 && md5($_POST["password"]) == $fetchPassword1)
	{
		$_SESSION["adid"] = 2;
		$_SESSION["adnm"] = 'Manager';

		header("location: reports_by_day.php");
	}
	else
	{
		echo "Invalid Username/Password. Please try again.";
	}