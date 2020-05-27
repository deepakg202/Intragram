
<?php require_once("./includes/config.php");?>
<?php
	if(isset($_POST['usernamecheck']))
	{
		$uname = sanitizeString($_POST['usernamecheck']);
		$q = getDBconn()->prepare("SELECT Count(Username) FROM users WHERE Username='$uname'");
		
		if($q->execute([$uname]))
			echo $q->fetchColumn();
		else
			echo 'Err';

		unset($_POST['usernamecheck']);
		exit;
	}
	
?>



<!DOCTYPE HTML>
<html>
	<head>
		<title>Intragram-SignUp</title>
		<?php require_once("./includes/includers.php"); ?>

	</head>
	<body>
		<?php require_once("./includes/header.php");?>
		

		<?php
		if(isset($_SESSION['user'])){
			header('location: index.php');
		}
		else{
		?>
		<section class="forms">
			<br /><br /><br /><br /><br />

			<?php
			$signupResponse = ''; 
			if(isset($_POST['signup_submit'])){
				unset($_POST['signup_submit']);                
				
				$name = sanitizeString($_POST['signupName']);
				$username = str_replace(' ','', sanitizeString($_POST['signupUsername']));
			    $email = sanitizeString($_POST['signupEmail']);
				$branch = sanitizeString($_POST['signupBranch']);
			    $desig = sanitizeString($_POST['signupDesig']);
			    $password = md5(sanitizeString($_POST['signupPassword']));
			    $contact = sanitizeString($_POST['signupContact']);
			    $gender = sanitizeString($_POST['signupGender']);
				$address = sanitizeString($_POST['signupAddress']);
			    $rollNo = sanitizeString($_POST['signupRollNo']);
				
				$profilepic = "https://api.adorable.io/avatars/512/".sanitizeString($username);
				
				$chk_eml = getDBconn()->prepare("SELECT COUNT(*) FROM users WHERE Email= :email");
				$chk_eml->execute([":email"=>$email]);

				$chk_cnct = getDBconn()->prepare("SELECT COUNT(*) FROM users WHERE Contact= :contact");
				$chk_cnct->execute([":contact"=>$contact]);

				$chk_uname = getDBconn()->prepare("SELECT COUNT(*) FROM users WHERE Username= :username");
				$chk_uname->execute([":username"=>$username]);
				
				if($chk_uname->fetchColumn() != 0)
				{
					$signupResponse = '<p class="text-danger">Username Not Available.</p>';
				}
				else if($chk_eml->fetchColumn() !=0){
					$signupResponse = '<p class="text-danger">Email Id Already Taken.</p>';
			    }
			    else if($chk_cnct->fetchColumn() !=0){
					$signupResponse = '<p class="text-danger">Contact No. Already Exist.</p>';
				}
			    else{
			        $quer = "INSERT INTO users (Name, Username, Email, Password, Branch, Designation, Contact, Gender, Address, RollNo, ProfilePic) ";
			        $quer .= "VALUES (?,?,?,?,?,?,?,?,?,?,?)";
					
					$addUser = getDBconn()->prepare($quer);
					
					if($addUser->execute([$name, $username, $email, $password, $branch, $desig, $contact, $gender, $address, $rollNo, $profilepic]))
					{
						$user = checkUser(getDBconn(), $email, $password);
						$_SESSION['user'] = $user->fetch();
						$signupResponse = '<p class="text-success">Account Created Succesfully</p>';
						header('refresh: 1');  
					}
					else
					{
						$signupResponse = '<p class="text-danger">Unknown Error Occurred</p>';
					}
					
			    }
			    unset($quer);
			    unset($chk_eml);
				unset($chk_cnct);
				unset($uname);
			}


			?>
			<div class="container p-4 rounded form-inner">
				
				<div class="page-header text-center">
					<h1 class="heading">Sign Up</h1>
					<div class="litline mx-auto"></div>
					<br/>
				</div>
				
				<p class="text-theme">Enjoy our services by Creating an Account</p>
				<form id="signupForm" method="POST">
					
					<div class="form-group">
						<label for="signupName" class="control-label">Name :</label>
						<input type="text" name="signupName" class="form-control" placeholder="Full Name" required>
						
					</div>

					<div class="form-group">
						<label for="signupEmail" class="control-label">Email :</label>
						<input type="email" name="signupEmail" class="form-control" placeholder="Email" required>
					</div>
					
					<div class="form-group">
						<label for="signupUsername" class="control-label">Username :</label>
						<input type="text" name="signupUsername" class="form-control" pattern=".{8,}" placeholder="Think a Username" required>
						<div class="invalid-feedback">Username Not Available</div>
					</div>



					<div class="form-group">
						<label for="signupDesig">Designation:</label>
						<select class="form-control" name="signupDesig" required>
							<option disabled selected>Select One</option>
							<option>Student</option>
							<option>Teacher</option>
						</select>
					</div>

					<div class="form-group">
						<label for="signupBranch">Branch:</label>
						<select class="form-control" name="signupBranch" required>
							<option disabled selected>Select One</option>
							<option>ECE</option>
							<option>CSE</option>
							<option>ME</option>
							<option>EEE</option>
							<option>CE</option>
						</select>
					</div>

					<div class="form-group">
						<label for="signupRollNo" class="control-label">Roll No. :</label>
						<input type="text" name="signupRollNo" class="form-control" placeholder="Your Roll No." required>
					</div>

					<div class="form-group">
						<label for="signupGender">Select Gender:</label>
						<select class="form-control" name="signupGender" required>
							<option disabled selected>Select One</option>
							<option>Male</option>
							<option>Female</option>
						</select>
					</div>					
					
					<div class="form-group">
						<label for="signupPassword" class="control-label">Password :</label>
						<input type="password" name="signupPassword" class="form-control" placeholder="Password" required>
					</div>
					
					<div class="form-group">
						<label class="control-label" for="signupContact">Contact No. :</label>
						<input type="tel" name="signupContact" class="form-control" placeholder="Contact" required>
					</div>
					
					
					<label class="control-label" for="signupAddress">Address :</label>
					<div class="form-group"><textarea name="signupAddress" wrap="hard" Placeholder="Address" class="form-control" required></textarea></div>
					
					
					<div><?php echo $signupResponse;?></div><br />
					<div class="d-flex flex-row justify-content-between">
						<div><a class="text-info" href="./login.php">Already Have An Account</a></div><br />
						<div><button type="submit" name="signup_submit" class="btn btn-theme" style="color: #1A1A1D;">Sign up</button></div>
					</div>
				</form>
				
				
			</div>
			<?php
			}
			?>
			<br><br>
			<br><br>
			<br><br>
		</section>
		<?php require_once("./includes/footer.php");?>
	
		<script>
		$('input[name="signupUsername"]').on('input', function(e) {
     		
			$.ajax({
				type: 'post',
				data: {usernamecheck: $(this).val()},
				success: (response)=>{
					if(response == 1 || $(this).val().length < 6) 
						$(this).removeClass("is-valid").addClass("is-invalid");
					else if(response >= 0 )
						$(this).removeClass("is-invalid").addClass("is-valid");
				}
				
			});
		});
	</script>
	
	</body>


	


</html>