<?php
	include_once 'universal.php';
	include_once "connect_db.php";

	if(isset($_POST["selected_server"]) && isset($_POST["user_login"]) && isset($_POST["user_password"]))
	{
		$mailhost = $_POST["selected_server"];
		$passwd   = $_POST["user_password"];
		
	//accepting full or short email both
		$user     = $_POST["user_login"];
		if(contains("@iitp.ac.in", $user))
		{
			$user = str_replace("@iitp.ac.in", "", $user);
		}			
		
		if($website == "localhost")
			$pop = true; // comment this while deploying
		else
			$pop = imap_open('{' . $mailhost . '}', $user, $passwd); //remove comment while deploying project		

		if ($pop == false) //email id not found in official iit patna's database
		{
			echo -1;
		} 
		else 
		{
			if($website == "localhost")
			{}
			else
				imap_close($pop); // un-comment this	
			
		//checking if user is authorized to login or not
			$email_address = $user . "@iitp.ac.in";
			$sql   = "SELECT * FROM notice_b_users where email_id = '$email_address'";

			$query = mysqli_query($connect_link ,$sql);
			if ($query->num_rows == 0) // user is not registered
			{			
				echo -2;				
			}
			else 
			{				
				$row      = $query->fetch_assoc();
				
				$logged_user_id   = $row['id'];
				$logged_user_name   = $row['name'];
		        $emp_id     = $row['emp_id'];
		      
			//setting cookie							
				setcookie('blogSite_logged_user_id', encrypt_decrypt('encrypt', $blogSite_logged_user_id), time()+($session_time*60), "/");
				setcookie('blogSite_logged_user_name', encrypt_decrypt('encrypt', $blogSite_logged_user_id), time()+($session_time*60), "/");
				setcookie('blogSite_logged_user_username', encrypt_decrypt('encrypt', $blogSite_logged_user_username), time()+($session_time*60), "/");
				
				echo 1;
			}	
		}
	}
	else
	{
		echo 0;
	}

	function contains($needle, $haystack)
	{
	    return strpos($haystack, $needle) !== false;
	}
?>