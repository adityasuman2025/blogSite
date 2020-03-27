<?php
	include_once "connect_db.php";
	include_once "encrypt.php";

	if(isset($_POST["login_username"]) && isset($_POST["login_password"]))
	{
		$login_username = trim(mysqli_real_escape_string($connect_link, $_POST["login_username"]));
		$login_password   = encrypt_decrypt("encrypt", trim($_POST["login_password"]));

		$query2 = "SELECT id FROM `users` WHERE username = '$login_username' AND password = '$login_password'";	
		if($result = @mysqli_query($connect_link ,$query2))		
		{
			if($result->num_rows == 1) // one user is registered
			{
				$result_array = mysqli_fetch_assoc($result);
				$id = $result_array['id'];

				echo encrypt_decrypt("encrypt", $id);
			}
			else
			{
				echo 0;
			}	
		}
		else
			echo -1;
	}
	else
	{
		echo -1;
	}
?>