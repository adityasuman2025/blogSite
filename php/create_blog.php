<?php
	include_once "connect_db.php";
	include_once "encrypt.php";

	if(isset($_POST["blog_text"]) && isset($_POST["img_address"]) && isset($_POST["user_id"]) && isset($_POST["username"]))
	{
		$blog_text = trim(mysqli_real_escape_string($connect_link, $_POST["blog_text"]));
		$img_address = trim(mysqli_real_escape_string($connect_link, $_POST["img_address"]));

		$user_id   = trim($_POST["user_id"]);
		$username   = trim($_POST["username"]);

		$query2 = "INSERT INTO `blogs` (`blog_text`, `img_address`, `added_by`, `added_by_name`) VALUES ('$blog_text', '$img_address', '$user_id', '$username')";	
		if(@mysqli_query($connect_link ,$query2))
			echo 1;
		else
			echo 0;
	}
	else
	{
		echo -1;
	}
?>