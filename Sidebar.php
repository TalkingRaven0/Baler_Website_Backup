<?php 
	if (session_status() === PHP_SESSION_NONE) {
    	session_start();
	}

	if(isset($_POST['variable']))
	
	if (!isset($_SESSION['id'])){
		header("Location: index.php");
		exit();
	}

	if (isset($_GET['logout'])){
		session_unset();
		session_destroy();
		header("Location: index.php");
		exit();
	}	
	
	$defaultpic = "https://www.baytekent.com/wp-content/uploads/2016/12/facebook-default-no-profile-pic1.jpg";
	$targetDir = "uploads/";
	$pagemark = 'style="color: #ce2543;"';
	$divepage = $mypage = $settings = "";

	if(isset($myposts)){
		$mypage = $pagemark;
	}

	if(isset($homepage)){
		$divepage = $pagemark;
	}

	if(isset($setting)){
		$settings = $pagemark;
	}

	if (!isset($_SESSION['uname'])){
		include 'dbtemp.php';

		// Get Data START

		$sql = "SELECT active , username, email, pass, filename FROM userinfo WHERE id = " . $_SESSION['id'];
		$result = $conn->query($sql);
		$row = $result-> fetch_assoc();

		$_SESSION['uname'] = $row['username'];
		$_SESSION['email'] = $row['email'];
		$_SESSION['active'] = $row['active'];
		if ($row['filename'] != ""){
			$_SESSION['pic'] = $targetDir.$row['filename'];
		}

		$conn->close();
	}
?>

<div class="sidenav">
	<img src="<?php echo isset($_SESSION['pic']) ? $_SESSION['pic'] : $defaultpic ?>" id="profpic"><br>
	<p style="text-align: center;"><b style="color: #ce2543;">@<?php echo $_SESSION['uname']?></b></p><br>
	<?php if ($_SESSION['active'] != '1') { ?>
		Account not Activated
	<?php } ?>
	<a <?php echo $divepage?> href="Home.php">DIVE</a>
	<a <?php echo $mypage?> href="myPosts.php">My Profile</a>
	<a <?php echo $settings?> href="AccountManagement.php">Settings</a><br>
	<a href="?logout">Logout</a>
</div>
<!-- ._. -->