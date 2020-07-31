<?php
	include_once "connect_db.php";
	include_once "encrypt.php";

	if(isset($_POST["login_email"]) && isset($_POST["login_password"]))
	{
		$email = trim(mysqli_real_escape_string($connect_link, @$_POST["login_email"]));
		$password   = encrypt_decrypt("encrypt", trim(@$_POST["login_password"]));

		//running query
		$mysql_qry = "SELECT id, type, name FROM users WHERE email = '$email' AND password = '$password'";
				
		if($result = @mysqli_query($connect_link ,$mysql_qry)) {
			if( @mysqli_num_rows($result) == 1 ) {
				$data = @mysqli_fetch_assoc($result);
				$type = $data['type'];
				$id = $data['id'];
				$name = $data['name'];

				if( $type == 2 ) {
				//admin
					$enc_id = encrypt_decrypt("encrypt", $id);
					$enc_name = encrypt_decrypt("encrypt", $name);

					$to_send = array();
					$to_send["id"] = $enc_id;
					$to_send["name"] = $enc_name;
					
					echo ( @json_encode($to_send) );
				} else {
					echo -2; //you are not a admin
				}
			} else {
				echo 0;
			}	
		}
		else {
			echo -1;
		}
	} else {
		echo -1;
	}
?>