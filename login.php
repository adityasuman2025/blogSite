<?php
	include_once("php/universal.php");

	if($isSomeOneLogged) //redirecting to the drive page
	{
		header("location: index.php");
		die();
	}
?>
<html>
<head>
	<title><?php echo $project_title; ?></title>
	<link href="css/login.css" rel="stylesheet"/>
	<link rel="icon" href="img/logo.png" />
	<script type="text/javascript" src="js/jquery.js"> </script>
	
	<meta name="viewport" content="width=device-width, initial-scale= 1">	
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="English">
	<meta name="author" content="Aditya Suman">	
</head>

<body>
<!-----main body container----->
<div class="body_container">
	<center>
		<br /><br /><br />
		<form class="login_form">
			<img src="img/logo.png" id="login_logo" />
			<h2 id="login_title"><?php echo $project_title; ?></h2>
			
			<input type="text" id="login_username" placeholder="Username">
			<br><br>

			<input type="password" id="login_password" placeholder="Password">
			<br>

			<div class="button-5">
			    <div class="translate"></div>
			    <button class="button_btn">Login</button>
			</div>
		</form>
		<div class="error"></div>
	</center>
</div>
	
<!-------script-------->
	<script type="text/javascript">
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

	//on clicking on go btn	    
		session_length = "<?php echo $session_time; ?>";
		api_address = "<?php echo $api_address; ?>";		

		$('.button-5').on("click", function(e)
		{
			e.preventDefault();
			
			var login_username = $('#login_username').val().trim();
			var login_password = $('#login_password').val().trim();

			if(login_username != "" && login_password != "")
			{
				$('.error').text("");
				$('.error').html("<img class=\"gif_loader\" src=\"img/loader1.gif\">");

				var post_address = api_address + "verify_user.php";
				$.post(post_address, {login_username: login_username, login_password: login_password}, function(data)
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
						$('.error').text("Invalid login credentials");
					}					
					else
					{
						setCookie('MNgoDrive_logged_user_id', data, session_length);
						location.href = "drive.php";
					}
				});	
			}
			else
				$('.error').text("Please fill all the fields");
		});
	</script>
</body>
</html>