<?php
	include_once "universal.php";
	include_once "connect_db.php";	

	if(isset($_POST["offset"]) && isset($_POST["pagination_count"]))
	{
		$offset = trim(mysqli_real_escape_string($connect_link, $_POST["offset"]));
		$pagination_count = trim(mysqli_real_escape_string($connect_link, $_POST["pagination_count"]));

		$mysql_qry   = "SELECT * FROM blogs ORDER BY blog_id DESC LIMIT $pagination_count OFFSET $offset";
	
		$result = @mysqli_query($connect_link ,$mysql_qry);
		if($result)
		{
			$html = "";
			while ($row = @mysqli_fetch_assoc($result)) 
			{
			//getting the blogs details
				$get_post_id = $row['blog_id'];
				$get_post_title = $row['blog_title'];
				$get_post_text = $row['blog_text'];
				$get_post_photo = $row['img_address'];

				$get_post_time = $row['added_on'];
				$added_by_name = $row['added_by_name'];

			//displaying blogs
				$html = $html . "<div class=\"post_div\">
									<h3 class=\"post_title_display\">
										" . $get_post_title . "
									</h3>
									<div class=\"post_text_container\">
										<div class=\"post_content_container\">";
											if($get_post_photo !="")
												$html= $html . "<center><img class=\"post_image_content\" src=\"$get_post_photo\" onerror=\"this.onerror=null;this.src='img/photo_placeholder.png';\" /></center>";
											
											if($get_post_text !="")
												$html= $html . "<textarea disabled class=\"post_text_content\">$get_post_text</textarea>";
				$html= $html . "		</div>";
				$html= $html . "	</div>";
				$html= $html . "	<div class=\"post_user_dp_name_mob\">
										<img class=\"post_dp_icon\" src=\"img/user.png\" onerror=\"this.onerror=null;this.src='img/user.png';\"/>";
											$html= $html . "<b>&nbsp $added_by_name</b> on ";
											$html= $html . "<a>" . date('h:i A d M Y', strtotime($get_post_time)) . "</a>";

									//showing delete button only if opened profile is of the loggined user
										if($isSomeOneLogged)
										{
											$html= $html . "<img class=\"post_action_button delt_btn\" src=\"img/delete.png\" id=\"delt_btn\" post_id=\"$get_post_id\">";
											$html= $html . "<img class=\"post_action_button edit_btn\" src=\"img/edit.png\" id=\"edit_btn\" post_id=\"$get_post_id\">";
										}
				$html= $html . "	</div>
								</div>";
			}

			echo trim($html);
		}
		else 
		{
			echo 0;
		}
	}
	else
	{
		echo -1;
	}
?>