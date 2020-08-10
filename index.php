<?php
	include_once 'php/universal.php';

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
			<!-------displyaing the posting area only to admin--->
				<?php			   	
			   		if($isSomeOneLogged)
			   		{
			   	?>			   	
			   		<div class="user_post col-xs-12 col-md-12">
						<div class="post_textarea_thumbnail row">
							<input type="text" class="post_title col-md-12 col-xs-12" placeholder="blog title">
							<input type="text" class="post_keywords col-md-12 col-xs-12" placeholder="keywords (seperated by comma , )">

							<textarea maxlength="2500" class="post_textarea col-md-12 col-xs-12" placeholder="write your blog"></textarea>
							<div class="post_thumbnail col-md-3 col-xs-12"></div>
						</div>

						<div class="col-xs-12 col-md-12 post_option">
							<div class="post_photo">
								<img src="img/photo.png">
								Upload Photo
								<input type="file" id="file" name="file" accept="image/*">
							</div>

							<button class="post_button">POST</button>
						</div>
						<div class="error"></div>
					</div>
			   	<?php
			   		}
		   		?>

			<!-----user post---->
				<div class="post_container col-xs-12 col-md-12">
					<form style="text-align: center; " action="search.php" method="get">
						<input type="text" class="search_by_keywords" placeholder="Search blog by keywords (separate by comma ,)">
						
						<button class="search_btn">Search</button>
					</form>
					<br />

					<?php
						$offset = 0;

						include_once("php/get_blogs.php");						

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
				<br>

				<div class="col-xs-12 col-md-12">
					<div class="load_more_post">load more...</div>
					<br /><br />
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
			session_length = "<?php echo $session_time; ?>";
			blog_image_secret_code = "<?php echo $blog_image_secret_code; ?>";

		//on clicking on logout btn
			$('#logout_btn').on('click', function()
			{
				$.post('php/logout.php', {}, function(data)
				{
					location.reload();
				});
			});
		
		//for uploading post image
			img_address = "";
			var post_address = "php/upload_file_on_server.php";
		    $(document).on('change', '#file', function()
		    {
		      	$('.error').html("<img class=\"gif_loader\" src=\"img/loader1.gif\">");

	      	//sending upload request to api 
		        var property = document.getElementById("file").files[0];
		        var image_name = property.name;
		        var image_extension = image_name.split('.').pop().toLowerCase();
		        
		        var form_data = new FormData();
				form_data.append("file", property);
				$.ajax(
				{
					url: post_address,
					method: "POST",
					data: form_data,
					contentType: false,
					cache: false,
					processData: false,
					beforeSend:function()
					{
						$('.error').html("<img class=\"gif_loader\" src=\"img/loader1.gif\" /></br>Uploading File").css('color', 'black');
					},
					success: function(data)
					{
						if(data == 0)
						{
							$('.error').text('Failed to upload file').css("color", 'red');
						}
						else if(data == -2)
						{
							$('.error').text("file uploading directory not present on server").css("color", 'red');
						}
						else if(data == -1)
						{
							$('.error').text("Something went wrong").css("color", 'red');
						}
						else
						{
							img_address = data.trim();
							$('.post_textarea').removeClass("col-md-12");
							$('.post_textarea').addClass("col-md-9");
							$('.post_thumbnail').html('<img src="' + img_address + '"/>');
							$('.error').html("");

						//adding image secret text in the blog_text
						//to recognize that image is present at that position
							var blog_text = $.trim($('.post_textarea').val());
							blog_text += ( "\n\n" + blog_image_secret_code + img_address + blog_image_secret_code + "\n\n" );
							$('.post_textarea').val(blog_text);
						}
					}
				});
		    });
		
		//on clicking on post btn
			$('.post_button').on("click", function()
			{				
				var blog_title = $.trim($('.post_title').val());
				var blog_keywords = $.trim($('.post_keywords').val());
				var blog_text = $.trim($('.post_textarea').val());

				$.post('php/create_blog.php', {blog_title: blog_title, blog_keywords: blog_keywords, blog_text: blog_text, img_address: img_address, user_id: blogSite_logged_user_id, username: blogSite_logged_user_username}, function(data)
				{
					if(data == -100)
					{
						$('.error').text("Database connection error");
					}
					else if(data == -1)
					{
						$('.error').text("Something went wrong");
					}
					else if(data == 0)
					{
						$('.error').text("Failed to create blog");
					}					
					else if(data == 1)
					{
						location.reload();
					}
					else
						$('.error').text("Unknown error");
				});
			});
		
		//on clickong on load more btn
			offset = "<?php echo $offset; ?>";			
			pagination_count = "<?php echo $pagination_count; ?>";

			offset = +offset + +pagination_count;
			$('.load_more_post').on("click", function()
			{
				// console.log(offset);
				$.post("php/get_limited_blogs.php", {offset: offset, pagination_count: pagination_count}, function(data)
				{
					data = data.trim();
					if(data != "" && data != 0 && data != -1 && data != -100)
					{
						$('.post_container').append(data);
						offset = +offset + +pagination_count;

					//on clicking on delt btn
						$('.delt_btn').on("click", function()
						{
							var post_id = $(this).attr('post_id');
							handleDeleteBlog(post_id);
						});

					//on clicking on edit btn
						$('.edit_btn').on('click', function()
						{
							var post_id = $(this).attr('post_id');
							handleEditBlog(post_id);
						});
					}

					if(data == "") // if no more blogs exits then hiding load more btn
					{
						$('.load_more_post').remove();
					}
				});
			});

		//on clicking on delt btn
			$('.delt_btn').on("click", function()
			{
				var post_id = $(this).attr('post_id');
				handleDeleteBlog(post_id);
			});

		//function to delete a blog
			function handleDeleteBlog(post_id)
			{
				if(confirm("Are you sure to delete")) //of ok is pressed
				{					
					$.post('php/delete_blog_by_id.php', {post_id: post_id}, function(data)
					{
						// console.log(data);
						if(data == -100)
						{
							$('.error').text("Database connection error");
						}
						else if(data == -1)
						{
							$('.error').text("Something went wrong");
						}
						else if(data == 0)
						{
							$('.error').text("Failed to delete the blog");
						}					
						else if(data == 1)
						{
							location.reload();
						}
						else
							$('.error').text("Unknown error");
					});
				}
			}

		//on clicking on edit btn
			$('.edit_btn').on('click', function()
			{
				var post_id = $(this).attr('post_id');
				handleEditBlog(post_id);
			});

			function handleEditBlog(post_id)
			{
				$.post('php/get_blog_by_id.php', {post_id: post_id}, function(data)
				{
					$('.overlay_backgrnd').fadeIn(300);
					$('.overlay_div').fadeIn(300);

					$('.overlay_content').html(data);

				//for uploading post image
					edit_img_address = $('.overlay_content').find('.edit_post_thumbnail').attr('src');

					var post_address = "php/edit_photo_on_server.php";
				    $(document).on('change', '#edit_file', function()
				    {
				      	$('.edit_error').html("<img class=\"gif_loader\" src=\"img/loader1.gif\">");

			      	//sending upload request to api 
				        var property = document.getElementById("edit_file").files[0];
				        var image_name = property.name;
				        var image_extension = image_name.split('.').pop().toLowerCase();
				        
				        var form_data = new FormData();
						form_data.append("edit_file", property);
						$.ajax(
						{
							url: post_address,
							method: "POST",
							data: form_data,
							contentType: false,
							cache: false,
							processData: false,
							beforeSend:function()
							{
								$('.edit_error').html("<img class=\"gif_loader\" src=\"img/loader1.gif\" /></br>Uploading File").css('color', 'black');
							},
							success: function(data)
							{		
								// console.log(data);
								if(data == 0)
								{
									$('.edit_error').text('Failed to upload file').css("color", 'red');
								}
								else if(data == -2)
								{
									$('.edit_error').text("file uploading directory not present on server").css("color", 'red');
								}
								else if(data == -1)
								{
									$('.edit_error').text("Something went wrong").css("color", 'red');
								}
								else
								{
									edit_img_address = data.trim();

									$('.edit_post_thumbnail').html('<img src="' + edit_img_address + '"/>');
									$('.edit_error').html("");

								//adding image secret text in the blog_text
								//to recognize that image is present at that position
									var blog_text = $.trim($('.edit_post_textarea').val());
									blog_text += ( "\n\n" + blog_image_secret_code + edit_img_address + blog_image_secret_code + "\n\n" );
									$('.edit_post_textarea').val(blog_text);
								}
							}
						});
				    });
				
				//on clicking on update btn
					$('.edit_post_button').on("click", function()
					{				
						var blog_title = $.trim($('.edit_post_title').val());
						var blog_keywords = $.trim($('.edit_post_keywords').val());
						var blog_text = $.trim($('.edit_post_textarea').val());

						$.post('php/update_blog_by_id.php', {post_id: post_id, blog_title: blog_title, blog_keywords: blog_keywords, blog_text: blog_text, img_address: edit_img_address, user_id: blogSite_logged_user_id, username: blogSite_logged_user_username}, function(data)
						{
							console.log(data);

							if(data == -100)
							{
								$('.error').text("Database connection error");
							}
							else if(data == -1)
							{
								$('.error').text("Something went wrong");
							}
							else if(data == 0)
							{
								$('.error').text("Failed to create blog");
							}					
							else if(data == 1)
							{
								location.reload();
							}
							else
								$('.error').text("Unknown error");
						});
					});
				});
			}

		//on clicking in close btn of overlay window
			$('.close_overlay_btn, .overlay_backgrnd').on("click", function()
			{
				$('.overlay_backgrnd').fadeOut(100);
				$('.overlay_div').fadeOut(100);
			});
		</script>
	</body>
</html>