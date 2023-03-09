<?php
	if (session_status() === PHP_SESSION_NONE){
    	session_start();
	}
	include 'dbtemp.php';

	if(isset($_SESSION['myposts'])){
		$sql = "SELECT postID, userID, content, upvotes,datecreated FROM posttable WHERE userID = ". $_SESSION['id'] ." ORDER BY datecreated DESC";
	}

	else{
		$sql = "SELECT postID, userID, content, upvotes, datecreated FROM posttable ORDER BY datecreated DESC";
	}	
	$array = $conn->query($sql);

	while($row = $array-> fetch_assoc()){
		$postID = $row['postID'];
		$userID = $row['userID'];
		$content = $row['content'];
		$upvotes = $row['upvotes'];
		$datecreated = $row['datecreated'];
		include 'postCard.php';
	}
?>
<!-- ._. -->