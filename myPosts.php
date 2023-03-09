<!DOCTYPE html>
<html>

<?php session_start(); ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link rel="icon" type="images/png" href="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/Ive_logo_%28Black%29.svg/1609px-Ive_logo_%28Black%29.svg.png">

    <title>My Profile | ArchIVE</title>
</head>

<?php
	$error = false;
	$myposts = true;
	$msgErr = "";
	$btnclass = "card text-white bg-danger";

	if(!isset($_SESSION['myposts']))
	{
		$_SESSION['myposts'] = true;
	}

	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	if (isset($_POST['post'])){

		if(empty($_POST["content"])){
			$msgErr = "You can't post nothing";
			$btnclass = "card text-white bg-danger";
			$error = true;
		}

		if($_SESSION['active'] != '1')
		{
			$error = true;
			$msgErr = 'You need to verify your account before you can post';
		}

		if(!$error){
			$content=test_input($_POST['content']);
			$id = $_SESSION['id'];

			include 'dbtemp.php';

			if (!$error){
				$sql = "INSERT INTO posttable (userID,content,datecreated) VALUES ('$id','$content', NOW())";

				if ($conn->query($sql) === TRUE){
					$msgErr = 'Post created successfully';
					$btnclass = "card text-white bg-success";
				}
			}
			$conn->close();	
		}
	}
?>

<body>
	<?php include 'Sidebar.php';?>

	<div class="main">
		<div id="banner"><img src="photos/group3.2jpg.jpg" style="width:100%; height:auto;" alt=""></div>
		
		<!-- Create New Post   -->
		<div id = "create" class="card">
			<div class="card-body" style="padding:0;">
			<?php 
				if ($msgErr != ""){
				echo '<br><span class="';echo $btnclass; echo'" style="width: 20rem; text-align: center; display: block; margin-left: auto; margin-right: auto; margin-bottom: -50px;">'; echo $msgErr; echo'</span>';
				}
			?>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="postcard" style="margin-top: 20px;">
				<div style="float:right;">
					<input type="submit" class="btn btn-primary" name="post" value="Post">
				</div>
				<img src="<?php echo isset($_SESSION['pic']) ? $_SESSION['pic'] : $defaultpic ?>" id="dp">
				<b style="color: #ce2543;">@<?php echo $_SESSION["uname"];?></b><br><br>
				<textarea class="form-control" name="content" rows="2" placeholder="DIVE into IVE" style="width: 100%"></textarea>
			</form>
			</div>
		</div>

		<!-- Posts loop -->
		<div id="posts" class="card">
			<?php include 'posts.php';?>
		</div>

		<?php $conn->close();?>

	</div>

</body>

	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</html>
<!-- ._. -->