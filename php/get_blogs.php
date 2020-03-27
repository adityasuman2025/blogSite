<?php
	include_once "connect_db.php";

	$mysql_qry   = "SELECT * FROM blogs ORDER BY blog_id DESC";
	
	$result = @mysqli_query($connect_link ,$mysql_qry);
	if($result)
	{
		$blogs_array = array();
		while ($row = mysqli_fetch_assoc($result)) 
		{
			array_push($blogs_array, $row);
		}		
	}
	else 
	{
		echo 0;
	}
?>