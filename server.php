<?php
error_reporting(0);
ini_set('default_charset','utf-8');
$database="hands_mr";
mysql_connect('localhost','hands_mr','root.1234');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

	$id = $_GET['id']; 
	//$description = $_GET['description']; 
	//$position = $_GET['position'];
	$query_string = "SELECT * 
	                 FROM item 
					 WHERE NOT EXISTS(SELECT * 
					 			      FROM data 
					 			      WHERE item.id= data.item_id and data.user_id = '$id')"; // 



	/*if (!empty($description)){
		$query_string = $query_string . ' WHERE `description`="' . $description . '" ';
	}

	if (!empty($name)){
		$query_string = $query_string . ' WHERE `coordinate`="' . $coordinate.'" '; 
	}

	if (!empty($position)){
		$query_string = $query_string . ' WHERE `position`="' . $position. '" '; 
	}
*/


	$link = mysql_connect('localhost','hands_mr','root.1234');
	if(!$link){
		die('Not connected : ' . mysql_error());
		$error = 'Not connected : ' . mysql_error();
		$arr = array('success' => false, 'error' => $error );
		echo json_encode($arr); 
	}


	$db_selected = @mysql_select_db($database);

	if(!$db_selected){
		die ("Database not selected : " . mysql_error());
		$error = "Database not selected : " . mysql_error();
		$arr = array('success' => false, 'error' => $error );
		echo json_encode($arr); 
	}
	//echo $query_string;

	$result = mysql_query($query_string);
	if(!$result){

		$error = 'Query failed '.mysql_error();
		$arr = array('success' => false, 'error' => $error );
		echo json_encode($arr); 
		exit();
	} else {
		$finalarray = array();
		while ($row = mysql_fetch_assoc($result)) { 
		$stack=array("id"=>$row['id'],"name"=>$row['name'],"description"=>$row['description'],"institution"=>$row['institution'],"language"=>$row['language'],"course_url"=>$row['course_url'],"image"=>$row['image'],"workload"=>$row['workload'],"instructors"=>$row['instructors'],"catagories"=>$row['catagories']);
		array_push($finalarray , $stack);
	}


	echo json_encode($finalarray);
	//$arr = urlencode(serialize(array('a'=>'小灰狼')));
	//echo $arr;
	}
	// get is done
	mysql_close(); 
}

else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id=$_POST['id'];
	$screen_name = $_POST['screen_name']; 
	$age= $_POST['age'];
	$gender = $_POST['gender'];
	$user_id = $_POST['userid'];
	$item_id = $_POST['itemid'];
	$rate = $_POST['rate'];
	//$markedby = $_POST['markedby'];


	// 1. check that all of the parameters are present
	if (!empty($id) && !empty($screen_name)){
		$link = mysql_connect('localhost','hands_mr','root.1234');
		if(!$link){
			die('Not connected : ' . mysql_error());
			$error = 'Not connected : ' . mysql_error();
			$arr = array('success' => false, 'error' => $error );
			echo json_encode($arr); 
		}

		$db_selected = @mysql_select_db($database);

		if(!$db_selected){
			die ("Database not selected : " . mysql_error());
			$error = "Database not selected : " . mysql_error();
			$arr = array('success' => false, 'error' => $error );
			echo json_encode($arr); 
		}
		$query_string_check = "SELECT * FROM user WHERE id = '$id'";
		$result = mysql_query($query_string_check);
		$row = mysql_fetch_array($result);

		if (empty($row)) {
			# code...
			$query_string = sprintf("INSERT INTO `" . $database . "`.`user` (`id`,`screen_name`,`age`,`gender`)
			VALUES( '%s','%s','%s','%s');",
			mysql_real_escape_string($id),
			mysql_real_escape_string($screen_name),
			mysql_real_escape_string($age),
			//mysql_real_escape_string($markedby),
			mysql_real_escape_string($gender)
			//mysql_real_escape_string($picurl)
		);
		
		//update
		echo $query_string;
		echo $database;

		if(!mysql_query($query_string))
		{

			$error = 'Query failed '.mysql_error();
			$arr = array('success' => false, 'error' => $error );
			echo json_encode($arr); 
			exit();
		} 
		else 
		{
			$arr = array('success' => true);
			echo json_encode($arr); 
		}
		}	

		mysql_close();

	}
	else if (!empty($user_id) && !empty($item_id)) {
	 	# code...
	 	$link = mysql_connect('localhost','hands_mr','root.1234');
		if(!$link){
			die('Not connected : ' . mysql_error());
			$error = 'Not connected : ' . mysql_error();
			$arr = array('success' => false, 'error' => $error );
			echo json_encode($arr); 
		}

		$db_selected = @mysql_select_db($database);

		if(!$db_selected){
			die ("Database not selected : " . mysql_error());
			$error = "Database not selected : " . mysql_error();
			$arr = array('success' => false, 'error' => $error );
			echo json_encode($arr); 
		}

		$query_string = sprintf("INSERT INTO `" . $database . "`.`data` (`user_id`,`item_id`,`rating`)
			VALUES( '%s','%s','%s');",
			mysql_real_escape_string($user_id),
			mysql_real_escape_string($item_id),
			mysql_real_escape_string($rate)
		);
		echo $query_string;
		echo $database;

		if(!mysql_query($query_string))
		{

			$error = 'Query failed '.mysql_error();
			$arr = array('success' => false, 'error' => $error );
			echo json_encode($arr); 
			exit();
		} 
		else 
		{
			$arr = array('success' => true);
			echo json_encode($arr); 
		}
		mysql_close();

	 }

	else {
		$arr = array('success' => false, 'error' => 'Not all variables given' );
		echo json_encode($arr); 
		//echo $user_id;
		//echo $item_id;
		echo $rate;


	}


}


else {

echo "Invalid request.";
}


//mysql_close();
?>