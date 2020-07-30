<?php
	include_once 'encrypt.php';

//global variables		
	$session_time = 60*24; //in minutes //1 day
	$project_title = "blogSite";
	$pagination_count = "4";

	$website = $_SERVER['HTTP_HOST']; //dns address of the site 
	if( $website == "localhost" || "localhost:8080" )
	{	
		$upload_address = "/opt/lampp/htdocs/blogSite/storage/";
		$$upload_address = "storage/";
	}
	else
	{
		$upload_address = "storage/"; //change this address when deplying somewhere else
	}	

	$isSomeOneLogged = false;
	if(isset($_COOKIE['blogSite_logged_user_id']))
	{
		$isSomeOneLogged = true;
	}
?>