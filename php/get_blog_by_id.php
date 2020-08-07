<?php
	include_once "connect_db.php";
	include_once "encrypt.php";

	if(isset($_POST["post_id"]))
	{
		$post_id = trim(mysqli_real_escape_string($connect_link, $_POST["post_id"]));
		
		$query2 = "SELECT * FROM `blogs` WHERE blog_id = '$post_id'";	
		if($result = @mysqli_query($connect_link ,$query2))		
		{
			$html = "";
			while ($row = mysqli_fetch_assoc($result)) 
			{
			//getting the blogs details
				$get_post_id = $row['blog_id'];
				$get_post_title = $row['blog_title'];
				$get_post_text = $row['blog_text'];
				$get_post_photo = trim($row['img_address']);

				$get_post_time = $row['added_on'];
				$added_by_name = $row['added_by_name'];

			//rendering html	
				$html = $html . "<div class=\"user_post col-xs-12 col-md-12\" style=\"padding-bottom: 20px; \">
									<div class=\"post_textarea_thumbnail row\">
										<input type=\"text\" class=\"edit_post_title col-md-12 col-xs-12\" placeholder=\"blog title\" value=\"$get_post_title\">

										<textarea maxlength=\"2500\" class=\"edit_post_textarea col-md-12 col-xs-12\" placeholder=\"write your blog\">$get_post_text</textarea>
										<div class=\"edit_post_thumbnail col-md-12 col-xs-12\" src=\"$get_post_photo\" >";

									if($get_post_photo != "")
										$html = $html . "<img onerror=\"this.onerror=null;this.src='img/photo_placeholder.png';\" />";									
					$html = $html . "</div>
									</div>

									<div class=\"col-xs-12 col-md-12 post_option\">
										<div class=\"post_photo\">
											<img src=\"img/photo.png\">
											Change Photo
											<input type=\"file\" id=\"edit_file\" name=\"edit_file\" accept=\"image/*\">
										</div>

										<button class=\"edit_post_button\">UPDATE</button>
									</div>
									
									<div class=\"edit_error\"></div>									
								</div>";
			}

			echo $html;
		}
		else
			echo -1;
	}
	else
	{
		echo -1;
	}
?>