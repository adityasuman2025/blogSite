<?php
	include_once 'php/universal.php';

    if( isset($_GET['search_by_keywords']) ) {
        $search_by_keywords = $_GET['search_by_keywords'];
        include_once("php/search_blogs_by_keywords.php");						
    } else {
        die("invalid request");
    }
?>

<html>
	<head>
		<title><?php echo $project_title; ?></title>

		<link href="css/bootstrap.min.css" rel="stylesheet"/>
		<link href="css/style.css" rel="stylesheet"/>
		<link rel="icon" href="img/logo.png" />
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script src="js/jquery.redirect.js"></script>

		<meta name="viewport" content="width=device-width, initial-scale= 1">	
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="language" content="English">
		<meta name="author" content="Aditya Suman">
	</head>

	<body>
	<!--------navigation bar---->
		<nav class="navbar navbar-inverse navbar-fixed-top">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      	<a class="navbar-brand">
		      		<div class="row">		      	
		      			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 x_m-p header_bar_title">
		      				<img src="img/logo.png" />
		      				<?php echo $project_title; ?>
		      			</div>
		      		</div>
				</a>
		    </div>
		   		
		   	<?php
		   	//displyaing name of the user if he is logged in
		   		if($isSomeOneLogged)
		   		{
		   			$blogSite_logged_user_id = encrypt_decrypt('decrypt', $_COOKIE['blogSite_logged_user_id']);
		   			$blogSite_logged_user_username = encrypt_decrypt('decrypt', $_COOKIE['blogSite_logged_user_username']);
		   	?>
		   		<ul class="nav navbar-nav">
		      		<li class="active"><a><img class="user_icon" src="img/user.png" /> <?php echo $blogSite_logged_user_username; ?></a></li>
		    	</ul>

			    <ul class="nav navbar-nav navbar-right">
			    	<li><a style="font-size: 120%; background: red; border-radius: 0px; color: white; cursor: pointer;" id="logout_btn" >Logout</a></li>
			    </ul>
			    <script type="text/javascript">
			    	blogSite_logged_user_id = "<?php echo $blogSite_logged_user_id; ?>";
					blogSite_logged_user_username = "<?php echo $blogSite_logged_user_username; ?>";
			    </script>
		   	<?php		
		   		}
		   		else
		   		{
	   			//showing login button
		   	?>		   	
			  	<ul class="nav navbar-nav navbar-right">
			    	<li class="active">
			    		<a href="login.php" class="log_btn" style="font-size: 120%; background-color: #6f42c1;" >Login</a>
			    	</li>
			    </ul>
		   	<?php		
		   		}
		   	?>
		  </div>
		</nav>

	<!--------main container------>
		<div class="container-fluid">		
			<div class="row window_row">
			<!-----user post---->
				<div class="post_container col-xs-12 col-md-12">
					<form style="text-align: center; " action="search.php" method="get">
						<input type="text" class="search_by_keywords"  name="search_by_keywords"  placeholder="Search blog by keywords (separate by comma ,)">
						<button class="search_btn">Search</button>
					</form>
					<br />

					<?php
						foreach ($blogs_array as $key => $blog)
						{
						//getting the blogs details
							$get_post_id = $blog['blog_id'];
							$get_post_title = $blog['blog_title'];
							$get_post_text = $blog['blog_text'];
							$get_post_photo = $blog['img_address'];

							$get_post_time = $blog['added_on'];
							$added_by_name = $blog['added_by_name'];

						//displaying blogs
							echo"<div class=\"post_div\">
									<h3 class=\"post_title_display\">
										$get_post_title
									</h3>
									<div class=\"post_text_container\">
										<div class=\"post_content_container\">";
											echo "<div class=\"post_text_content\" >";

											//if that post contains some text then displaying it line-by-line
												if($get_post_text !="") {
													$blog_text_line_arr = explode( "\n", $get_post_text );
													// print_r($blog_text_line_arr);
													foreach( $blog_text_line_arr as $blog_text_line ) {
													//checking if text contains image
														if( contains( $blog_image_secret_code, $blog_text_line ) ) {
														//if it contains image then dislaying the image
															$img_location = str_replace( $blog_image_secret_code ,"",$blog_text_line );
															echo "<img class=\"post_image_content\" src=\"$img_location\" onerror=\"this.onerror=null;this.src='img/photo_placeholder.png';\" />";
														} else {
															echo "<div>" . $blog_text_line . "</div>";
														}
													}
												}
											echo "</div>";
							echo "		</div>";
							echo 	"</div>";
							echo "	<div class=\"post_user_dp_name_mob\">
											<img class=\"post_dp_icon\" src=\"img/user.png\" onerror=\"this.onerror=null;this.src='img/user.png';\"/>";
												echo "<b>&nbsp $added_by_name</b> on ";
												echo "<a>" . date('h:i A d M Y', strtotime($get_post_time)) . "</a>";
										//showing delete button only if opened profile is of the loggined user
											if($isSomeOneLogged) {
												echo "<img class=\"post_action_button delt_btn\" src=\"img/delete.png\" id=\"delt_btn\" post_id=\"$get_post_id\">";
												echo "<img class=\"post_action_button edit_btn\" src=\"img/edit.png\" id=\"edit_btn\" post_id=\"$get_post_id\">";
											}
							echo "	</div>
								</div>";
						}
					?>
				</div>
			</div>
		</div>	

	<!--------overlay modal--------->
		<div class="overlay_backgrnd"></div>
		<div class="overlay_div">
			<div class="close_overlay_btn"></div>
			<br />
			<div class="overlay_content"></div>
		</div>

		
	<!---------script--------->
		<script type="text/javascript">
		//on clicking on logout btn
			$('#logout_btn').on('click', function()
			{
				$.post('php/logout.php', {}, function(data)
				{
					location.reload();
				});
			});
		</script>
	</body>
</html>