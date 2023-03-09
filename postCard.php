<?php
	$sql = "SELECT username, filename FROM userinfo WHERE id = ".$userID;
	$result = $conn->query($sql);
	$userID = $result-> fetch_assoc();
	$defaultpic = "https://www.baytekent.com/wp-content/uploads/2016/12/facebook-default-no-profile-pic1.jpg";
	$filename = $userID['filename'] != "" ? "uploads/".$userID['filename'] : $defaultpic;
	$userID = $userID['username'];
	$upID = "up".$postID;
	$downID = "down".$postID;
?>

<div id = "postcard">
	<?php
		ob_start();
		if(isset($_POST['vote'.$postID])){
			if($_POST['vote'.$postID] == "up"){
				$operation = "+";
			}

			else{
				$operation = "-";
			}
			$sql = "UPDATE posttable SET upvotes = " .$upvotes.$operation. "1 WHERE postID= " .$postID;
			$conn->query($sql);

			eval("\$upvotes ".$operation."= 1;");
		}

		if(isset($_SESSION['myposts'])){
			$postedit = "edit".$postID;
			$confedit = "confirm".$postID;
			$cancel = "cancel".$postID;
			$editErr = "";
			
			if(!isset($_SESSION[$postedit])){
				$_SESSION[$postedit] = false;
			}

			if (!function_exists('test_input')){
				function test_input($data){
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
				}
			}

			if (isset($_POST['content'.$postID])){
				$contentedit = test_input($_POST['content'.$postID]);

				if(empty(trim($contentedit))){
					$editErr = "You can't post nothing";
				}

				else{
					$sql = "UPDATE posttable SET datecreated = NOW(), content= '" .$contentedit. "' WHERE postID= " .$postID;
					$conn->query($sql);
					$_SESSION[$postedit] = false;
					$content = $contentedit;
					header('Location: '.$_SERVER['REQUEST_URI']);
					die();
				}	
			}

			if(isset($_POST[$postedit]))
			{
				if($_POST[$postedit] == 'on')
				{
					$_SESSION[$postedit] = true;
				}
				else
				{
					$_SESSION[$postedit] = false;
				}
				
			}

			if(isset($_POST[$postID])){
				if($_POST[$postID] == 'true')
				{
					$sql = "DELETE FROM posttable WHERE postID = ".$postID;
					$conn->query($sql);
					header('Location: '.$_SERVER['REQUEST_URI']);
					die();
				}
				else if($_POST[$postID] == 'cancel')
				{
					unset($_POST[$postID]);
				}	
			}
			
			echo '<div style="float: right; text-align:center">';
				if(!$_SESSION[$postedit])
				{
					if(isset($_POST[$postID]))
					{
						echo "Delete this post?&nbsp";
						echo'<button class="btn btn-primary" onclick="delpost';echo $postID;echo '(\'true\')">Yes</button>&nbsp;&nbsp;';
						echo'<button class="btn btn-danger" onclick="delpost';echo $postID;echo '(\'cancel\')">No</button>&nbsp;&nbsp;';
					}
					else
					{
						echo'<button id ="del" title="delete" onclick="delpost';echo $postID;echo '(\'false\')"></button>&nbsp;&nbsp;';
						echo'<button id ="edit" title="edit" onclick="editmode';echo $postID;echo '(\'on\')"></button>';
					}					
				}
			echo'</div>';
			

			
		}
	?>

	<!-- user -->
	<img src="<?php echo $filename ?>" id="dp">
	<b style="color: #ce2543;">@<?php echo $userID;?></b><br><br>
	
	<!-- This whole div is the content -->
	<div>
		<?php
			if(isset($_SESSION['myposts'])){
				if($_SESSION[$postedit]){
					// Edit Form
					echo '<div id="postcard">';
						echo $editErr;
						echo'<textarea id="content'; echo $postID; echo'" rows="5" style="width: 100%">';echo $content ;echo'</textarea><br><br>';
						echo'<button class="btn btn-primary" style="float:right;" onclick="editpost';echo $postID;echo '(\'down\')">Save</button>';
						echo'<button class="btn btn-danger" style="float:right; margin-right: 10px;" onclick="editmode';echo $postID;echo '(\'off\')">Cancel Edit</button>';
					echo'</div>';
				}
				else{ // Print Content
					echo $content;
				}
			}
			else{echo $content;}
			echo "<br><br>".$datecreated;
		?>
	</div>
	<br>
	<!-- upvotes -->
	<div class="d-flex align-items-center">
		<span class="badge d-flex align-items-center text-justify"style="height:30px; padding: 0px 10px 0px 10px; background-color: black">Points&nbsp;<?php echo $upvotes ?></span>&nbsp;
		<button id="vote" title="upvote" onclick="upv<?php echo $postID?>('up')"></button>
		<button id="vote2" title="downvote" onclick="upv<?php echo $postID?>('down')"></button>
	</div><br>
	<hr style="color:blue;">
</div>

<script>
	function upv<?php echo $postID?>(text){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		    if (this.readyState == 4 && this.status == 200) {
			    document.getElementById("posts").innerHTML =
			    this.responseText;
		    }
		  };
		xhttp.open("Post", "posts.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("vote<?php echo $postID?>="+text);
	}
</script>

<?php if(isset($_SESSION['myposts'])){ ?>

	<script>
		function editpost<?php echo $postID?>(){
			var xhttp = new XMLHttpRequest();
			var text = $('textarea#content'+<?php echo $postID?>).val();
			xhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200){
				    document.getElementById("posts").innerHTML =
				    this.responseText;
			    }
			  };
			xhttp.open("Post", "posts.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("content<?php echo $postID?>="+text);
		}

		function editmode<?php echo $postID?>(text){
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
			    if (this.readyState == 4 && this.status == 200){
				    document.getElementById("posts").innerHTML =
				    this.responseText;
			    }
			  };
			xhttp.open("Post", "posts.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("<?php echo $postedit?>="+text);
		}

		function delpost<?php echo $postID?>(text){
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200){
				    document.getElementById("posts").innerHTML =
				    this.responseText;
			    }
			};
			xhttp.open("Post", "posts.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("<?php echo $postID?>="+text);
		}
	</script>

<?php } ?>
<!-- ._. -->