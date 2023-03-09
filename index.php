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

    <title>Log-in | archIVE</title>
</head>

    <?php
		// define variables and set to empty values
		$error = false;
		$unameErr = "";
		$uname = $pass = "";

		if ($_SERVER["REQUEST_METHOD"] == "POST"){
			session_start();

			if(empty($_POST["password"])){
				$unameErr = "Password is Empty";
				$error = true;
				$_SESSION['pass'] = null;
			}
			else{
				$pass = test_input($_POST["password"]);
				$_SESSION['pass'] = $pass;
			}

            if(empty($_POST["username"])){
				$unameErr = "Username is Empty";
				$error = true;
				$_SESSION['username'] = null;
			}
			else{
				$uname = test_input($_POST["username"]);
				$_SESSION['username'] = $uname;
			}

			// If there are no errors go to submitlogin.php
			if(!$error){
				include 'dbtemp.php';

				$sql = "SELECT id, username, pass FROM userinfo";
				$result = $conn->query($sql);

				while($row = $result-> fetch_assoc()){
					if ( $row["username"] == $uname){
						if($row["pass"] == $pass){
							session_unset();
							$_SESSION['id'] = $row["id"];
							$conn->close();
							// Relocate to Home
							header("Location: Home.php");
						}
						break;
					}

				}
				$unameErr = "Incorrect username or password";
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

    <section id="carousel">

		<div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
  			<div class="carousel-indicators">
    		<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    		<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
    		<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
    		<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3" aria-label="Slide 4"></button>
    		<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="4" aria-label="Slide 5"></button>
    		<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="5" aria-label="Slide 6"></button>
    		<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="6" aria-label="Slide 7"></button>
    		<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="7" aria-label="Slide 8"></button>
    		<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="8" aria-label="Slide 9"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="9" aria-label="Slide 10"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="10" aria-label="Slide 11"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="11" aria-label="Slide 12"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="12" aria-label="Slide 0"></button>
  		</div>

  		<div class="carousel-inner">
	    	<div class="carousel-item active">
	      		<img src="photos/group5.jpg" class="d-block w-100" alt="">
	   	 	</div>
	    	<div class="carousel-item">
	      		<img src="photos/gaeul1.jpg" class="d-block w-100" alt="">
	    	</div>
	    	<div class="carousel-item">
                <img src="photos/yujin1.jpg" class="d-block w-100" alt="">
	    	</div>
	    	<div class="carousel-item">
                <img src="photos/rei1.jpg" class="d-block w-100" alt="">
	    	</div>
	    	<div class="carousel-item">
                <img src="photos/won1.jpg" class="d-block w-100" alt="">
	    	</div>
	    	<div class="carousel-item">
                <img src="photos/liz1.jpg" class="d-block w-100" alt="">
	    	</div>
	    	<div class="carousel-item">
                <img src="photos/leeseo1.jpg" class="d-block w-100" alt="">
	    	</div>
	    	<div class="carousel-item">
	      		<img src="photos/gaeul2.jpg" class="d-block w-100" alt="">
	    	</div>
	    	<div class="carousel-item">
                <img src="photos/yujin2.jpg" class="d-block w-100" alt="">
	    	</div>
	    	<div class="carousel-item">
                <img src="photos/rei2.jpg" class="d-block w-100" alt="">
	    	</div>
	    	<div class="carousel-item">
                <img src="photos/won2.jpg" class="d-block w-100" alt="">
	    	</div>
	    	<div class="carousel-item">
                <img src="photos/liz2.jpg" class="d-block w-100" alt="">
	    	</div>
	    	<div class="carousel-item">
                <img src="photos/leeseo2.jpg" class="d-block w-100" alt="">
	    	</div>
  		</div>

		<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"  data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Previous</span>
		</button>

		<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"  data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Next</span>
		</button>
	</section>

    <div class="container-fluid" style = "margin: 0;position: absolute;top: 50%;transform: translateY(-50%);">
	  	<div class="row">

			<div class="col-sm-6">
			</div>

			<div class="col-sm-6" style="padding-right: 10%;">
				<div class="card" style="width: 25rem; margin-left: 20px;">
					<div class="card-body">
						<!-- Sign in Fields START -->
						<img src="photos/logo.jpg" style="width:100px; height:100px; border-radius:50%; display: block; margin-left: auto; margin-right: auto; margin-bottom: 25px;" alt="">
						<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="g-3" method = "post">
							<input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''?>"><br>
							<input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo isset($_SESSION['pass']) ? $_SESSION['pass'] : ''?>"><br>
							<?php 
								if ($unameErr != ""){
									echo '<span class="card text-white bg-danger mb-3" style="width: 100%; text-align: center; padding:5px;">'; echo $unameErr; echo'</span>';
								}
							?>
							<input type="submit" class="btn btn-primary" value="Log - in" style="width: 100%;">
						</form>
						<hr>
						<div style="width: 100%; font-size: 13px; text-align: center;">
							Don't have an account yet?
							<a href="SignupPage.php">Sign Up Now!</a>
							<!-- Sign in Fields END -->
						</div>
					</div>
				</div>
			</div> 
	    </div>
	</div>
</body>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</html>
<!-- ._. -->