<?php
	include_once "connect_db.php";

	if(isset($_POST["post_id"]))
	{
		$post_id = trim(mysqli_real_escape_string($connect_link, $_POST["post_id"]));

		$query2 = "DELETE FROM `blogs` WHERE blog_id = '$post_id'";	
		if($result = @mysqli_query($connect_link ,$query2))		
			echo 1;
		else
			echo 0;
	}
	else
		echo -1;	
?>