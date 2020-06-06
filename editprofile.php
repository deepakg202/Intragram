<?php require_once("./includes/config.php");?>
<?php
	if(isset($_POST['usernamecheck']))
	{
		$uname = sanitizeString($_POST['usernamecheck']);
		$q = getDBconn()->prepare("SELECT Count(username) FROM users WHERE username='$uname'");
		
		if($q->execute())
			echo $q->fetchColumn();
		else
			echo 'Err';

		unset($_POST['usernamecheck']);
		exit;
	}

	function alertBox($message)
	{
		echo '<script>alert("'.$message.'");</script>';
	}
	
?>


<!DOCTYPE HTML>
<html>

<head>
	<title>Intragram-EditProfile</title>
	<?php require_once("./includes/config.php");?>
	<?php require_once("./includes/includers.php"); ?>
</head>

<body>
	
	<?php require_once("./includes/header.php");?>
	<br /><br /><br /><br /><br />
	<?php
		if(isset($_SESSION['user'])){ 
            $user = $_SESSION['user'];
            if(!isset($editResponse))
                $editResponse = '';

            

            if(isset($_POST['editprof_submit']))
            {
                $uid = $user['id'];
				$name = sanitizeString($_POST['editName']);
				$username = str_replace(' ','', sanitizeString($_POST['editUsername']));
			    $email = sanitizeString($_POST['editEmail']);
			    $password = md5(sanitizeString($_POST['editPassword']));
			    $contact = sanitizeString($_POST['editContact']);
				$about = sanitizeString($_POST['editAbout']);
				$profilepic = sanitizeString($_POST['editProfilePic']);
                
                $chk_pswd = getDBconn()->prepare("SELECT COUNT(password) FROM users WHERE id=? AND password=?");
                if($chk_pswd->execute([$uid, $password]))
                {
                    if(($chk_pswd->fetchColumn()) == 1)
                    {
                        $edit = getDBconn()->prepare("UPDATE users SET name=?, email=?, username=?, contact=?, profile_pic=?, about=? WHERE id=?");
						
						if($edit->execute([$name, $email, $username, $contact, $profilepic, $about, $uid]))
                        {
							$editResponse = 'Successful Edit';
							$user = checkUser(getDBconn(), $email, $password);
							$_SESSION['user'] = $user->fetch();
						}
						else
						{
							$editResponse = 'Error Occured. Try Again later!';
							
						}
						
					}
					else
					{
						$editResponse = 'Incorrect Password';
					}
                }
                else
                {
                    $editResponse = 'Error Occured. Try Again Later!';
				}

				alertBox($editResponse);
				header('refresh: 0');
				exit();
               
			}
			else{

			
	?>

	<section id="profile" class="pt-3">
		<div class="container">
			<div class="row">
				<div class="col-md-3">

					<div class="sticky-top" style="top: 70px;">
						
						<div class="profile-pic">
							<img class=" rounded-circle p-2 img-fluid" src="<?=$user['profile_pic'];?>" style="height: 256px; width: 256px;" onerror="this.src='images/no-image.png';" />
						</div>


						<div class="profile-detail pt-2">
							<h2><?=$user['name'];?></h2>
                            <h3><?=$user['username'];?></h3>
							<h4><?=$user['about'];?></h4>
						</div>
						<br />
						<div class="profile-nav py-3">
							<div class="d-flex flex-md-column flex-sm-row justify-content-around">
								<a class="p-2" href="profile.php"><span class="fa fa-file-text fa-fw"></span>
									Your Posts</a>
								<a class="p-2  btn-link disabled active-nav" href="editprofile.php"><span class="fa fa-user fa-fw"></span> Edit Profile</a>
								<a class="p-2" href="changepassword.php"><span class="fa fa-wrench fa-fw"></span> Change Password</a>
							</div>
						</div>

					</div>
				</div>

				<div class="col-md-9 container">
                
                
				<input type="file" accept="image/*" class="d-none" id="file_browser">
				
                <form id="editProfileForm" method="POST">
					
					<div class="form-group">
						<label for="editName" class="control-label">Name :</label>
						<input type="text" name="editName" class="form-control" value="<?=$user['name']?>" placeholder="Full Name" required>
						
					</div>

					<div class="form-group">
						<label for="editEmail" class="control-label">Email :</label>
						<input type="email" name="editEmail" class="form-control" placeholder="Email" value="<?=$user['email']?>" required>
					</div>
					
					<div class="form-group">
						<label for="editUsername" class="control-label">Username :</label>
						<input type="text" name="editUsername" class="form-control" value="<?=$user['username']?>" pattern=".{6,}" placeholder="Think a Username" required>
						<div id="error-username" class="invalid-feedback">Username Already In Use</div>
						
					</div>

                    <div class="form-group">
					  <label for="editProfilePic">Profile Pic:</label>
					  <div class="input-group mb-2 mr-sm-2">
							<div class="input-group-prepend">
								<button onclick="FileBrowse();return false;" class="input-group-text text-dark" id="shortlinker">Browse</button>
							</div>
							<input type="url" class="form-control" name="editProfilePic" value="<?=$user['profile_pic']?>"placeholder="Upload image to imgur">
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label" for="editContact">Contact No. :</label>
						<input type="tel" name="editContact" class="form-control" value="<?=$user['contact']?>" placeholder="Contact" required>
					</div>
					
					
					<label class="control-label" for="editAbout">About :</label>
					<div class="form-group"><textarea name="editAbout" wrap="hard" Placeholder="Tell Us About Yourself" initial="<?=$user['about']?>" class="form-control" ></textarea></div>
					
                    <div class="form-group">
						<label for="editPassword" class="control-label">Password :</label>
						<input type="password" name="editPassword" class="form-control" placeholder="Current Password" required>
					</div>

					<div><?php echo $editResponse;?></div><br />
					<div><button type="submit" name="editprof_submit" class="btn btn-theme" style="color: #1A1A1D;">Confirm Edit</button></div>
					
				</form>



				</div>

			</div>
		</div>
	</section>
	<?php 
	
		}
	}
		else{
			header('location: ./login.php');
		}
		?>

	<br><br>
	<br><br>
	<br><br>
	<?php require_once("./includes/footer.php");?>
    <script>

		$('input[name="editUsername"]').on('input', function(e) {
			$('button[name="editprof_submit"]').attr('disabled', true);	
			if($(this).val() == '<?=$user['username']?>')
			{	
				$('button[name="editprof_submit"]').attr('disabled', false);
			}
			else if($(this).val().length<6)
			{
				$(this).removeClass("is-valid").addClass("is-invalid");
				$('#error-username').html('Username should be more than six characters');
			}
			else{
				$.ajax({
					type: 'post',
					data: {usernamecheck: $(this).val()},
					success: (response)=>{
						if(response >= 1) 
						{
							$(this).removeClass("is-valid").addClass("is-invalid");					
							$('#error-username').html('Username Already in Use');
						}
						else if(response == 0 )
						{
							$(this).removeClass("is-invalid").addClass("is-valid");
							$('button[name="editprof_submit"]').attr('disabled', false);	
						}
					}
					
				});
			}
		});


        function FileBrowse(){
				$('#file_browser').trigger('click');
				return false;
			}
			


			$("#file_browser").change(function(){
				$('#shortlinker').prop('disabled', true);
				$('input[name="editProfilePic"]').prop('disabled', true);
				$('input[name="editProfilePic"]').prop('placeholder', 'Uploading and fetching link....');
				
				$('button[name="editprof_submit"]').attr('disabled', true);

				let data = new FormData();
				let img = $(this).prop('files')[0];
				data.append('image', img);
	
				$.ajax({
					type: "POST",
					enctype: 'multipart/form-data',
					url: "api/imgur_upload.php",
					processData: false,  // Important!
					contentType: false,
					cache: false,
					data: data,
					success: function (response) {
						if(response.hasOwnProperty('data'))
						{
							$('input[name="editProfilePic"]').prop('placeholder', 'Uploaded Succesfully');
							$('input[name="editProfilePic"]').val(response.data.filePath);
						}
					},
					error: function(err){
						$('input[name="editProfilePic"]').prop('placeholder', 'Error Occured'+err.responseJSON.error);
					},

					complete: function(){
						$('input[name="editProfilePic"]').prop('disabled', false);
						$('#shortlinker').prop('disabled', false);
						$('button[name="editprof_submit"]').attr('disabled', false);
					}
				});
        	});


		
	</script>
</body>

</html>




