<!DOCTYPE HTML>
<html>

<head>
	<title>Intragram-ViewProfile</title>
	<?php require_once("./includes/config.php");?>
	<?php require_once("./includes/includers.php"); ?>
</head>

<body>

	<?php require_once("./includes/header.php");?>
	<br /><br /><br /><br /><br />
	<?php
		if(isset($_SESSION['user']) && isset($_GET['u']) && !empty($_GET['u'])){ 
			$user = $_SESSION['user'];

			$u = sanitizeString($_GET['u']);

			if($u==$user['username'])
			{
				header('location: profile.php');
				exit();
			}

			$view_quer = getDBconn()->prepare("SELECT id, name, profile_pic, username, about FROM users WHERE username=?");

			if($view_quer->execute([$u]))
			{
				$view = $view_quer->fetch();
				if(empty($view))
				{
					header('location: index.php');
					exit();
				}
			}
			else
			{
				header('location: index.php');
				exit();
			}

			
	?>

	<section id="profile" class="pt-3">
		<div class="container">
			<div class="row">
				<div class="col-md-3">

					<div class="sticky-top" style="top: 70px;">
						
						<div class="profile-pic">
							<img class=" rounded-circle p-2 img-fluid" src="<?=$view['profile_pic']?>" style="height: 256px; width: 256px;" onerror="this.src='images/no-image.png';" />
						</div>


						<div class="profile-detail pt-2">
							<h2><?=$view['name']?></h2>
							<h3><?=$view['username']?></h3>
							<h4><?=$view['about']?></h4>
						</div>
						<br />
						

					</div>
				</div>

				<div class="col-md-9 container">

					<!-- Blog Posts -->


					<?php 
							printBlog(getDBconn(), $view['id'], 3);
							
					?>





				</div>

			</div>
		</div>
	</section>
	<?php }
		else{
			header('location: ./login.php');
		}
		?>


	<br><br>
	<br><br>
	<br><br>
	<?php require_once("./includes/footer.php");?>
</body>

</html>




