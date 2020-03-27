<?php
	include_once 'php/universal.php';

	if(isset($_COOKIE['section_cookie']))
	{
		
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
		<nav class="navbar navbar-inverse">
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
		      		<li class="active"><a href="dashboard.php"><img class="user_icon" src="img/user.png" /> <?php echo $blogSite_logged_user_username; ?></a></li>
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
			<div class="row">
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
	
		//on clicking on view btn
			$('.view_btn').on('click', function()
			{
				viewClickHandle($(this));
			});

			function viewClickHandle(e)
			{
				var location = e.attr("location");

				$.redirect(location,
		        {
		            //location: location
		        }, "GET", "_blank");			 
			}
		</script>
	</body>
</html>