<?php
	include_once 'universal.php';
	include_once "connect_db.php";

//creating the required folder if folder is not present	
	$fold_status = 0;	
	if (!file_exists($upload_address)) 
	{
		$oldmask = umask(0); //for giving all permission to the folder
	    if(mkdir($upload_address, 0777, true))
	    {
	    	umask($oldmask);

	    	$fold_status = 1;
	    }		    			   
	}
	else
		$fold_status = 1;

//uploading file	
	if($fold_status == 1)//folder where file is to be uploaded exists
	{
		if($_FILES['file']["name"] != '')
		{
			$name = trim(mysqli_real_escape_string($connect_link, $_FILES['file']["name"]));
			$file_extension = strtolower(substr(strrchr($name, '.'), 1) ); //extension name of the file

		//removing special symbol from name of the file to be uploaded	
			$find = array("$", ",", "`", "~", ">", "<", "'", "\"","]","[","]","{","}","=","+",")", "(", "^", "!", "/","-", "@", "#","%","&", "*",";", ":", "|", " ", "?", "\\", ".");
			$trimmed_name = str_replace($find, "_", $name);
			$trimmed_name = $trimmed_name . "_" . time();
			
			$encrypted_name = encrypt_decrypt("encrypt", $trimmed_name);

		//getting new name of the file
			$new_name = $encrypted_name . "." .$file_extension;
			$upload_location = $upload_address . $new_name;

		//adding uploaded file info in db
			if(move_uploaded_file($_FILES['file']['tmp_name'], $upload_location))
			{
				echo "storage/" . $new_name;
			}
			else
				echo 0;
		}	
		else
		{
			echo 0; //file uploading failed
		}		
	}
	else
	{
		echo -2; //file uploading directory not present in server
	}
?>