<!DOCTYPE HTML>
<html>
	<head>
		<title>NuStart-Dashboard</title>
		<?php require_once("../includes/config.php");?>
		<?php require_once("../includes/includers.php"); ?>
	</head>
	<body>
		
		<?php require_once("../includes/header.php");?>
		<br /><br /><br /><br /><br />
		<?php
		if(isset($_SESSION['user'])){ 
			$user = $_SESSION['user'];
			$name = $user['Name'];
			$desig = $user['Designation'];
			$cmp_name = $user['Branch'];
			?>
		
		<section id="profile" class="pt-3">
			<div class="container">
				<div class="row">
					<div class="col-md-3">
						<div class="profile-pic">
						<img class="img-fluid rounded bg-white p-2" src="../images/user.png">
					</div>
						<div class="profile-detail pt-2">
							<h2><?php echo $name;?></h2>
							<h3><?php echo $desig;?></h3>
							<h4><?php echo $cmp_name;?></h4>
						</div>
						<br/>
						<div class="profile-nav py-3">
							<div class="d-flex flex-md-column flex-sm-row justify-content-around">
							 <a class="p-2 active-nav" href="index.php"><span class="fa fa-user fa-fw"></span> Overview</a>
							 <a class="p-2" href="log.php"><span class="fa fa-list-alt fa-fw"></span> Activity Log</a>
							 <a class="p-2" href="settings.php"><span class="fa fa-cog fa-fw"></span> Settings</a>
							</div>
						</div>

					</div>
					
					<div class="col-md-9 container">
						<!-- OVERVIEW -->
						<?php 
						$pend_ord = getDBconn()->exec("SELECT * FROM orders WHERE Status='Pending'");
						$comp_ord = getDBconn()->exec("SELECT * FROM orders WHERE Status='Completed'");
						?>
						<div class="d-flex text-center justify-content-center card-group">
							<div class="card py-2 mx-4 bg-warning text-dark rounded">
								<h3>Pending Orders</h3>
								<h5><?php echo $pend_ord; ?></h5>
							</div>
							<div class="card py-2 mx-4 bg-warning text-dark rounded">
								<h3>Completed Orders</h3>
								<h5><?php echo $comp_ord; ?></h5>
							</div>
						</div>

						<div class=""></div>
							
					</div>

				</div>
			</div>
		</section>
		<?php }
		else{
			header('location: ../login.php');
		}
		?>
		<br><br>
		<br><br>
		<?php require_once("../includes/footer.php");?>
	</body>
</html>