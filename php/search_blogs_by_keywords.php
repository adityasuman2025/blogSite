<?php
	include_once "connect_db.php";

//making query
    $search_by_keywords = trim(mysqli_real_escape_string($connect_link, $search_by_keywords));
    $search_keywords_arr = explode(",", $search_by_keywords);

    $keyword_count = count($search_keywords_arr);
    if( $keyword_count < 2 ) {
        $search_qry = "WHERE (blog_keywords LIKE '%" . $search_by_keywords . "%' )";
    } else {
        $search_qry = "WHERE";
        foreach( $search_keywords_arr as $search_keywords ) {
            $search_keywords = trim($search_keywords);
            $search_qry = $search_qry . " (blog_keywords LIKE '%" . $search_keywords . "%' ) OR";
        }
        $search_qry = rtrim( $search_qry," OR");
    }
    
//running query
	$mysql_qry   = "SELECT *
                    FROM blogs "
                    . $search_qry .
                    " ORDER BY blog_id DESC";
    
    $blogs_array = array();
	if( $result = @mysqli_query($connect_link ,$mysql_qry) ) {
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($blogs_array, $row);
		}
	}
?>