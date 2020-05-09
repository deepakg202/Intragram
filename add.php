<!DOCTYPE HTML>
<html>
	<head>
		<title>Intragram-AddPost</title>
		
		<?php require_once("./includes/config.php");?>
		<?php require_once("./includes/includers.php"); ?>
	
		<script src="./js/easymde.min.js"></script>
		<link href="./css/easymde.min.css" rel="stylesheet">



	</head>
	<body>
		
		<?php require_once("./includes/header.php");?>
		
		<?php
		$uploadResponse = '';
		if(isset($_SESSION['user'])){ 
			$user = $_SESSION['user'];
			
			?>

		
		<section class="forms">
			<br /><br /><br /><br /><br />
			
		<?php

		if(isset($_POST['post_submit']))
		{
			unset($_POST['post_submit']);

			// $img = $_FILES['postImage'];
			$postHeading = sanitizeString($_POST['postHeading']);
			$blogname = $user['id'].'_'.time();
			
			$addquer = getDBconn()->prepare("INSERT INTO blog (BlogId, Heading, UserId) VALUES (? , ? , ?)");
			if($addquer->execute([$blogname, $postHeading, $user['id']]))
			{
				$blogfile = fopen(ROOT_PATH."/uploads/blog/${blogname}.md", 'w');
				fwrite($blogfile, $_POST['postBody']);
				fclose($blogfile);

				$uploadResponse = '<div class="jumbotron container">Posted Successfully</div>';
				header("location: index.php");
			}
			else
			{
				$uploadResponse = 'Error Occured';
			}

			

		}else{

			
		?>
			<div class="container p-4 rounded">
				
				<div class="page-header text-center">
					<h1 class="heading">Post Something</h1>
					<div class="litline mx-auto"></div>
					<br/>
				</div>
				<?php echo $uploadResponse;?>
				<form id="addPostForm" method="POST" enctype="multipart/form-data">

					<div class="form-group">
						<label for="postHeading">*Heading:</label>
						<textarea class="form-control" style="font-size: 35px;font-weight: 500; color: black;" placeholder="Write A Nice Heading" id="heading" name="postHeading" required></textarea>
					</div>
					
					<div class="form-group">
						<label for="postBody">Body:</label>
						<div class="bg-white">
						<textarea class="form-control" name="postBody" placeholder="Markdown Supported" id="mde"></textarea>
						</div>
					</div>

					<!-- <div class="form-group">
						<label for="postImage">Upload An Image</label>
						<input accept="image/*" type="file" class="form-control-file" name="postImage">
					</div> -->

					
					<hr>
					<!-- <button type="submit" name="post_submit" class="btn btn-theme">Post</button> -->

					<style>
			.postBtn {
				bottom: 40px;
				right: 40px;
			}
			
			.postBtn:hover {
				background-color: red; /* Add a dark-grey background on hover */
			}
		</style>   
		<button type="submit" name="post_submit" class="postBtn position-sticky p-4 float-right btn btn-theme rounded-circle"><i class="fa fa-2x fa-paper-plane"></i></button>

				</form>
				
				
			</div>
			<br><br>
			<br><br>
			<br><br>
		
		</section>
	<script>
		var easyMDE = new EasyMDE({element: document.getElementById('mde'),showIcons: ['code', 'table'], hideIcons: ['fullscreen', 'side-by-side'], autosave: {enabled: true}, placeholder: "Powered By EasyMDE"});
	</script>
	

		<?php 
		}	
	}
		else{
			header('location: ./login.php');
		}
		?>

		
		<?php require_once("./includes/footer.php");?>
		
	</body>
</html>