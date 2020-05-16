<!DOCTYPE HTML>
<html>

<head>
	<title>Intragram</title>
	<?php require_once("./includes/config.php");?>
	<?php require_once("./includes/includers.php"); ?>
</head>

<body>

	<?php require_once("./includes/header.php");?>
	<br /><br /><br /><br /><br />
	<?php
		if(isset($_SESSION['user'])){ 
			$user = $_SESSION['user'];
			$name = $user['Name'];
			$desig = $user['Designation'];
			$branch = $user['Branch'];
			?>

	<section id="allposts" class="pt-3">
		<div class="container">
			<div class="row">
				
				<div class="col-md-9 container">

					<!-- Blog Posts -->


					<?php 
							printBlog(getDBconn(), 'all', 2);
				
					?>


				</div>

				<div class="col-md-3">
					<div class="sticky-top" style="top: 100px">
							Something To Add
					</div>
				</div>
			
			</div>
		</div>
	</section>
	<?php }
		else{
			header('location: ./login.php');
		}
		?>

	<!-- NEW POST BUTTON -->
	<style>
		.postBtn {
			bottom: 40px;
			right: 40px;
		}

		.postBtn:hover {
			background-color: red;
			/* Add a dark-grey background on hover */
		}
	</style>
	<a type="button" class="postBtn position-sticky p-4 float-right btn btn-theme rounded-circle" href="add.php"><i
			class="fa fa-2x fa-plus-circle"></i></a>

	<!-- END NEW POST BUTTON -->



	<br><br>
	<br><br>
	<br><br>
	<?php require_once("./includes/footer.php");?>
</body>

</html>





