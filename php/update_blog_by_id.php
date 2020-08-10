<?php
	include_once "connect_db.php";
	include_once "encrypt.php";

	if(isset($_POST["post_id"]) && isset($_POST["blog_keywords"]) && isset($_POST["blog_title"]) && isset($_POST["blog_text"]) && isset($_POST["img_address"]) && isset($_POST["user_id"]) && isset($_POST["username"]))
	{
		$post_id = trim(mysqli_real_escape_string($connect_link, $_POST["post_id"]));

		$blog_title = trim(mysqli_real_escape_string($connect_link, $_POST["blog_title"]));
		$blog_keywords = trim(mysqli_real_escape_string($connect_link, $_POST["blog_keywords"]));
		$blog_text = trim(mysqli_real_escape_string($connect_link, $_POST["blog_text"]));

		$img_address = trim(mysqli_real_escape_string($connect_link, $_POST["img_address"]));

		$user_id   = trim($_POST["user_id"]);
		$username   = trim($_POST["username"]);

		$query2 = "UPDATE `blogs`SET blog_title = '$blog_title', blog_keywords = '$blog_keywords', blog_text = '$blog_text', img_address = '$img_address' WHERE blog_id = $post_id";	
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