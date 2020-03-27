<?php
	include_once "universal.php"; 

	if(isset($_COOKIE['notice_no']) && isset($_COOKIE['notice_section']) && isset($_COOKIE['notice_date']))
	{		
	//getting cookies
		$notice_no = encrypt_decrypt('decrypt', $_COOKIE['notice_no']);
		$notice_section = encrypt_decrypt('decrypt', $_COOKIE['notice_section']);
		$notice_date_str = encrypt_decrypt('decrypt', $_COOKIE['notice_date']);

	//getting year from the notice_date	
		$notice_date = strtotime($notice_date_str);
		$iprOfYear = date('Y',$notice_date);

		if($notice_no != "" && $notice_section !="" && $iprOfYear !="")
		{
		//removing special symbol from name of the file to be uploaded	
			$find = array("/","-", "@", "#","%","&", ".", "*",";", ":", "|", " ", "?", "\\");
			$notice_no = str_replace($find, "_", $notice_no);

		//getting folder where the file is to be uploaded	
			$file_id = "file";

			$dir_to_upload_this_file = "pdf/" . $iprOfYear . "/" . $notice_section;
			$dir_to_upload = $project_address . "../" . $dir_to_upload_this_file;

		//creating the required folder if folder is not present	
			$fold_status = 0;	
			if (!file_exists($dir_to_upload)) 
			{				
				$oldmask = umask(0); //for giving all permission to the folder
			    if(mkdir($dir_to_upload, 0777, true))
			    {
			    	umask($oldmask);
			    	$fold_status = 1;
			    	// echo "folder created";
			    }
			    else
			    {
			    	// echo "fail to create folder";
			    }
			}
			else
			{
				// echo "folder already exist";
				$fold_status = 1;
			}

			if($fold_status == 1)//folder where file is to uploaded exists
			{
				//Ref.No.IITP/Acad/2018/Notice/SA-01
				if($_FILES[$file_id]["name"] != '')
				{
				//getting name of the file								
					$file_extension = strtolower( substr( strrchr($_FILES[$file_id]['name'], '.') ,1) ); //extension name of the file
					
					//$timestamps = time();

					$new_name = strtolower($notice_no) . "_" . $iprOfYear . "_" . $notice_section . "_NoTiCe." . $file_extension; 
					$upload_location = $dir_to_upload ."/". $new_name;
					
				//uploading file 	
					if(move_uploaded_file($_FILES[$file_id]['tmp_name'], $upload_location))
						echo $dir_to_upload_this_file ."/". $new_name;
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
		}
		else
		{
			echo -1;
			//array_push($errors, "Something went wrong");
		}	
	}
	else
	{
		echo -1;
		//array_push($errors, "Something went wrong");
	}
?>

