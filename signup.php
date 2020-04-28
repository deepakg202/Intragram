<!DOCTYPE HTML>
<html>
	<head>
		<title>NuStart-SignUp</title>
		<?php require_once("./includes/config.php");?>
		<?php require_once("./includes/includers.php"); ?>

	</head>
	<body>
		<?php require_once("./includes/header.php");?>
		

		<?php
		if(isset($_SESSION['user'])){
			header('location: dashboard/index.php');
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
			    $email = sanitizeString($_POST['signupEmail']);
				$branch = sanitizeString($_POST['signupBranch']);
			    $desig = sanitizeString($_POST['signupDesig']);
			    $password = md5(sanitizeString($_POST['signupPassword']));
			    $contact = sanitizeString($_POST['signupContact']);
			    $gender = sanitizeString($_POST['signupGender']);
				$address = sanitizeString($_POST['signupAddress']);
			    $rollNo = sanitizeString($_POST['signupRollNo']);
				

				
				$chk_eml = getDBconn()->prepare("SELECT COUNT(*) FROM users WHERE Email= :email");
				$chk_eml->execute([":email"=>$email]);

				$chk_cnct = getDBconn()->prepare("SELECT COUNT(*) FROM users WHERE Contact= :contact");
				$chk_cnct->execute([":contact"=>$contact]);
				
				if($chk_eml->fetchColumn() !=0){
					 $signupResponse = '<p class="text-danger">Email Id Already Taken.</p>';
			    }
			    else if($chk_cnct->fetchColumn() !=0){
					$signupResponse = '<p class="text-danger">Contact No. Already Exist.</p>';
			    }
			    else{
			        $quer = "INSERT INTO users (Name, Email, Password, Branch, Designation, Contact, Gender, Address, RollNo) ";
			        $quer .= "VALUES ('$name','$email', '$password', '$branch', '$desig', '$contact', '$gender', '$address', $rollNo)";
					getDBconn()->exec($quer);
					
					$user = checkUser(getDBconn(), $email, $password);
					$_SESSION['user'] = $user->fetch();

					$signupResponse = '<p class="test-success">Account Created Succesfully</p>';
					header('refresh: 1');
			        
			    }
			    unset($quer);
			    unset($chk_eml);
			    unset($chk_cnct);
			}


			?>
			<div class="container p-4 rounded form-inner">
				
				<div class="page-header text-center">
					<h1 class="heading">Sign Up</h1>
					<div class="litline mx-auto"></div>
					<br/>
				</div>
				
				<p class="text-warning">Enjoy our services by Creating an Account</p>
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
					<div class="row">
						<div class="col"><a class="text-info" href="./login.php">Already Have An Account</a></div><br />
						<div class="col text-right"><button type="submit" name="signup_submit" class="btn btn-warning" style="color: #1A1A1D;">Sign up</button></div>
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
	</body>
</html>