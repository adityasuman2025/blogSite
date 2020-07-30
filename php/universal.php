<?php
	include_once 'encrypt.php';

//global variables		
	$session_time = 60*24*15; //in minutes //15 days
	$project_title = "ML Certific";
	$pagination_count = "4";

	$website = $_SERVER['HTTP_HOST']; //dns address of the site 
	if( $website == "localhost" || "localhost:8080" )
	{	
		$upload_address = "storage/";
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