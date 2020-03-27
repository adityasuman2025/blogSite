<?php
	include_once 'encrypt.php';

//global variables		
	$session_time = 60*24; //in minutes //1 day
	$project_title = "blogSite";

	$website = $_SERVER['HTTP_HOST']; //dns address of the site 
	if($website == "localhost")
	{	
		$project_address = "/opt/lampp/htdocs/blogSite/";
		$project_address = "";
	}
	else
	{
		$project_address = ""; //change this address when deplying somewhere else
	}	

	$isSomeOneLogged = false;
	if(isset($_COOKIE['blogSite_logged_user_id']))
	{
		$isSomeOneLogged = true;
	}
?>