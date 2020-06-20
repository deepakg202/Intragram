<!DOCTYPE HTML>
<html>

<head>
	<title>Intragram-Profile</title>
	<?php require_once("./includes/config.php");?>
	<?php require_once("./includes/includers.php"); ?>
</head>

<body>

	<?php require_once("./includes/header.php");?>
	<br /><br /><br /><br /><br />
	<?php
		if(isset($_SESSION['user'])){ 
			$user = $_SESSION['user'];
			
	?>

	<section id="profile" class="pt-3">
		<div class="container">
			<div class="row">
				<div class="col-md-3">

					<div class="sticky-top" style="top: 70px;">
						
						<div class="profile-pic">
							<img class=" rounded-circle p-2 img-fluid" src="<?=$user['profile_pic']?>" style="height: 256px; width: 256px;" onerror="this.src='images/no-image.png';" />
						</div>


						<div class="profile-detail pt-2">
							<h2><?=$user['name']?></h2>
							<h3><?=$user['username']?></h3>
							<h4><?=$user['about']?></h4>
						</div>
						<br />
						<div class="profile-nav py-3">
							<div class="d-flex flex-md-column flex-sm-row justify-content-around">
								<a class="p-2 btn-link disabled active-nav" href="profile.php"><span class="fa fa-file-text fa-fw"></span>
									Your Posts</a>
								<a class="p-2" href="editprofile.php"><span class="fa fa-user fa-fw"></span> Edit Profile</a>
								<a class="p-2" href="changepassword.php"><span class="fa fa-wrench fa-fw"></span> Change Password</a>
							</div>
						</div>

					</div>
				</div>

				<div class="col-md-9 container">

					<!-- Blog Posts -->


					<?php 
							printBlog(getDBconn(), $user['id'], 3);
							
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
	<script>
		$(".blogcard").on('click', function(e){
			e.stopPropagation();
			var fullpost = ($($(this).find('.post-content')));
			fullpost.html('<div class="d-flex align-items-center"><p>Loading...</p><div class="spinner-border ml-auto"></div></div>');
			$.get($(this).attr('href'), null, function(text){
				fullpost.html($($(text).find('#blogcontent')).html());			
			});
			fullpost.removeClass('post-content');			
			return false;
		});
	</script>
</body>

</html>




