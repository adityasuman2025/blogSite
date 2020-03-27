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
		      	<a class="navbar-brand" href="index.php">
		      		<div class="row">		      	
		      			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 x_m-p header_bar_title">
		      				<img src="img/logo.png" class="" />
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
		   	<?php		
		   		}
		   		else
		   		{
	   			//showing login button
		   	?>		   	
			  	<ul class="nav navbar-nav navbar-right">
			    	<li class="active">
			    		<a href="login.php" class="log_btn" style="font-size: 120%; background-color: #4ac12c;" >Login</a>
			    	</li>
			    </ul>
		   	<?php		
		   		}
		   	?>
		  </div>
		</nav>

	<!--------main container------>
		<div class="container-fluid">
		<!------notification table-------->	
			<div class="row window_row">
				<br />
				<?php
			   	//displyaing the posting area only to admin
			   		if($isSomeOneLogged)
			   		{
			   	?>
			   		<div class="user_post col-xs-12 col-md-12">
						<div class="post_textarea_thumbnail row">
							<textarea maxlength="2500" class="post_textarea col-md-12 col-xs-12" placeholder="write your blog"></textarea>
							<div class="post_thumbnail col-md-3 col-xs-12"></div>
						</div>
						<div class="post_option">
							<span class="post_photo">
								<img src="img/photo.png">
								Upload Photo
								<input type="file" id="file" name="file" accept="image/*">								
							</span>						
							<br />
							<button class="post_button">POST</button>
						</div>
						<div class="error"></div>
					</div>
			   	<?php
			   		}
		   		?>
			</div>
		</div>	

	<!---------script--------->
		<script type="text/javascript">
			session_length = "<?php echo $session_time; ?>";
			
		//function to handle cookies  
		    function setCookie(name,value,mins) 
		    {
		       	var now = new Date();
		        var time = now.getTime();
		        var expireTime = time + 60000 * mins;
		        now.setTime(expireTime);
		        var tempExp = 'Wed, 31 Oct 2012 08:50:17 GMT';

		      document.cookie =  name + "=" + value + ";expires=" + now.toGMTString() + ";path=/";
		    }

		    function getCookie(name) {
		        var nameEQ = name + "=";
		        var ca = document.cookie.split(';');
		        for(var i=0;i < ca.length;i++) {
		            var c = ca[i];
		            while (c.charAt(0)==' ') c = c.substring(1,c.length);
		            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		        }
		        return null;
		    }

		    function eraseCookie(name) 
		    {
		    	var now = new Date(); 
		        document.cookie = name + '=; expires=' + now.toGMTString() + ";path=/";
		    }

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
						// console.log(data);
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
							img_address = data;
							$('.post_textarea').removeClass("col-md-12");
							$('.post_textarea').addClass("col-md-9");
							$('.post_thumbnail').html('<img src="' + img_address + '"/>');
							$('.error').html("");
						}
					}
				});
		    });
		</script>
	</body>
</html>