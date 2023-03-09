<!DOCTYPE html>
<html lang="en">
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

    <title>Sign-up | archIVE</title>

</head>

<?php
	$error = false;
	$unameErr = $emailErr = $passErr = "";

	if (session_status() === PHP_SESSION_NONE) {
    	session_start();
	}
	//File uploading variables


	if ($_SERVER["REQUEST_METHOD"] == "POST"){

		if(isset($_POST["accountbtn"]))
		{
			include 'dbtemp.php';
			$sql = "SELECT id, username FROM userinfo";
			$result = $conn->query($sql);
			while($row = $result-> fetch_assoc())
			{
				if($row['username'] == $_SESSION['username'])
				{
					session_unset();
					$_SESSION['id'] = $row['id'];
					header('Location: AccountManagement.php');
					exit();
					break;
				}
				
			}
			
		}

		$_SESSION['username'] = test_input($_POST["username"]);
		$_SESSION['pass'] = test_input($_POST["password"]);
		$_SESSION['email'] = test_input($_POST["email"]);
		$_SESSION['pass2'] = test_input($_POST["password2"]);

		if(empty($_POST["username"])){
			$unameErr = "Username is Required";
			$error = true;
		}

		elseif (strlen($_POST['username']) < 5){
			$unameErr = "Username should be at least 5 characters";
			$_SESSION['username'] = test_input($_POST["username"]);
			$error = true;
		}

		if(empty($_POST["email"])){
			$emailErr = "Email is Required";
			$error = true;
		}

		else{
			if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
				$emailErr = "Invalid email format";
				$error = true;
			}	
		}

		if(empty($_POST["password"])){
			$passErr = "Password is Required";
			$error = true;
		}

		elseif (strlen($_POST['password']) < 5){
			$passErr = "Password should be at least 5 characters";
			$error = true;
		}

		else{
			if($_SESSION['pass'] != $_SESSION['pass2']){
				$passErr = "Password does not match";
				$error = true;
			}
		}

		// If there are no errors go to submitlogin.php
		if(!$error){
			$x=$_SESSION['username'];
			$y=$_SESSION['email'];
			$z=$_SESSION['pass'];

			include 'dbtemp.php';

			$sql = "SELECT id, username, email FROM userinfo";
			$result = $conn->query($sql);
			while($row = $result-> fetch_assoc()){
				if ( $row["username"] == $x){
					$unameErr = "Username is already taken!";
					$error = true;
				}

				if ( $row["email"] == $y){
					$emailErr = "This Email already has an existing account";
					$error = true;
				}
			}

			if (!$error){
				$code = rand(10000,50000);
				$sql = "INSERT INTO userinfo (code,username,email,pass, datecreated) VALUES ('$code','$x','$y','$z', NOW())";

				if ($conn->query($sql) === TRUE){
					$_SESSION['signed'] = true;
					include 'verifcode.php';
					}
				
			}

			$conn->close();
		}
	}

	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>

<body id="insig">
    <div class="container-fluid" style = "margin: 0;position: absolute;top: 50%;transform: translateY(-50%);">
		<div class="row">

			<div class="col-sm-4"></div>

			<div class="col-sm-8" style="padding-right: 10%;">
				<div class="card" style="width: 25rem; margin-left: 20px; box-shadow:0 50px 50px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;">
					<div class="card-body">
						<img src="photos/logo.jpg" style="width:100px; height:100px; border-radius:50%; display: block; margin-left: auto; margin-right: auto; margin-bottom: 25px;" alt="">

						<?php if(isset($_SESSION['signed'])){ ?>

							<!-- This is the Post Signup Screen stuff -->
							<div style="font-size: 20px; text-align: center; margin: 20px 0px 20px 0px;">Thank you for signing up!<br><br>Please go to your Email to get your code and enter it into your account for verification!</div>

							<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "post">
								<input type="submit" name = "accountbtn" class="btn btn-primary" style="width: 100%;" value="Go to Account">
							</form>

							<!-- Post signup screen end -->

						<?php unset($_SESSION['signed']);}else{ ?>
							<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "post">
								<input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''?>"><br>
								<?php 
									if ($unameErr != ""){
										echo '<span class="card text-white bg-danger mb-3" style="width: 100%; text-align: center; padding:5px; margin-top: -8px;">'; echo $unameErr; echo'</span>';
									}
								?>
								<input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''?>"><br>
								<?php 
									if ($emailErr != ""){
										echo '<span class="card text-white bg-danger mb-3" style="width: 100%; text-align: center; padding:5px; margin-top: -8px;">'; echo $emailErr; echo'</span>';
									}
								?>
								<input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo isset($_SESSION['pass']) ? $_SESSION['pass'] : ''?>"><br>
								<input type="password" name="password2" class="form-control" placeholder="Repeat Password" value="<?php echo isset($_SESSION['pass2']) ? $_SESSION['pass2'] : ''?>"><br>
								<?php 
									if ($passErr != ""){
										echo '<span class="card text-white bg-danger mb-3" style="width: 100%; text-align: center; padding:5px; margin-top: -8px;">'; echo $passErr; echo'</span>';
									}
								?>
								<input type="submit" class="btn btn-primary" style="width: 100%;" value="Submit">
							</form>
						<?php } ?>
					</div>
				</div> 
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</body>
</html>
<!-- ._. -->