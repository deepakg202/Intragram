<!DOCTYPE HTML>
<html>
	<head>
		<title>Intragram-LogIn</title>
		<?php require_once("./includes/config.php");?>
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
			
			$loginResponse = '';
			
			if(isset($_POST['login_submit'])){
				unset($_POST['login_submit']);
				$email = sanitizeString($_POST['loginEmail']);
				$password = md5(sanitizeString($_POST['loginPassword']));
				
				//checkUser defined in config
				$chk=checkUser(getDBconn(), $email, $password);
				
				if($chk->rowcount()==1)
				{
					$user = $chk->fetch();
					$_SESSION['user'] = $user;
					$loginResponse = '<p class="text-success">Logged In Successfully</p>';
					header('refresh: 1');
				}
				else{
					$loginResponse = '<p class="text-danger">Incorrect Credentials!</p>';
				}
				unset($chk);
			}
			?>
			<div class="container p-4 rounded form-inner">
				
				<div class="page-header text-center">
					<h1 class="heading">Log In</h1>
					<div class="litline mx-auto"></div>
					<br/>
				</div>
				<p class="text-theme">Please Login To Continue</p>
				<form id="loginForm" method="POST">
					<div class="form-group"><input type="email" class="form-control" name="loginEmail" placeholder="Email" required></div>
					<div class="form-group"><input type="password" class="form-control" name="loginPassword" placeholder="Password" required></div>
					<div><?php echo $loginResponse;?></div><br />
					
					<div class="row">
						<div class="col"><a class="text-info" href="./signup.php">Don't Have An account ?</a></div><br />
						<div class="col text-right"><button type="submit" name="login_submit" class="btn btn-theme" style="color: #1A1A1D;">Log in</button></div>
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