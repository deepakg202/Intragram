
<!DOCTYPE HTML>
<html>
	<head>
		<title>Intragram-AddPost</title>
		
		<?php require_once("./includes/config.php");?>
		<?php require_once("./includes/includers.php"); ?>
	
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

			$postImage = sanitizeString($_POST['postImage']);
			$postHeading = sanitizeString($_POST['postHeading']);
			$blogname = $user['id'].'_'.time();
			
			$addquer = getDBconn()->prepare("INSERT INTO blog (blog_id, heading, user_id, image_link) VALUES (? , ? , ? , ?)");
			if($addquer->execute([$blogname, $postHeading, $user['id'], $postImage]))
			{
				$blogfile = fopen(ROOT_PATH."/uploads/blog/${blogname}.md", 'w');
				fwrite($blogfile, sanitizeString($_POST['postBody']));
				fclose($blogfile);

				echo '<div class="jumbotron container display-4">Posted Successfully !<br>Redirecting to Your Post....</div>';
				echo '<meta http-equiv="refresh" content="3;url=./view.php?pid='.$blogname.'"> ';
			
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
				<?=$uploadResponse;?>

				<input type="file" accept="image/*" class="d-none" id="file_browser">
				
				<form id="addPostForm" method="POST" enctype="multipart/form-data">

					<div class="form-group">
						<label for="postHeading">*Heading:</label>
						<textarea class="form-control" style="font-size: 35px;font-weight: 500; color: black;" placeholder="Write A Nice Heading" id="heading" name="postHeading" required></textarea>
					</div>

					<div class="form-group">
					  <label for="postImage">Image of Post:</label>
					  <div class="input-group mb-2 mr-sm-2">
							<div class="input-group-prepend">
								<button onclick="FileBrowse();return false;" class="input-group-text text-dark" id="shortlinker">Browse</button>
							</div>
							<input type="url" class="form-control" name="postImage" placeholder="Link to image to show in home page">
						</div>
					</div>

					<div class="form-group">
						<label for="postBody">Body:</label>
						<div class="bg-white text-dark">
						<textarea class="form-control" name="postBody" placeholder="Markdown Supported" id="mde"></textarea>
						</div>
					</div>

					

					<style>
					.postBtn {
						bottom: 40px;
						right: 40px;
						z-index: 999;
					}
					
					.postBtn:hover {
						background-color: red;
					}
					</style>   
					<button type="submit" name="post_submit" class="postBtn position-sticky p-4 float-right btn btn-theme rounded-circle"><i class="fa fa-2x fa-paper-plane"></i></button>

			</form>
				
				
			</div>
			<br><br>
			<br><br>
			<br><br>
		
		</section>
			

		<?php 
		}	
	}
		else{
			header('location: ./login.php');
		}
		?>

		
		<?php require_once("./includes/footer.php");?>
		
		<script src="./js/easymde.min.js"></script>
		
		<script>
			var md = new EasyMDE({
				element: document.getElementById('mde'),
				showIcons: ['code', 'upload-image', 'table'],  
				//autosave: {enabled: true, uniqueId: " "}, 
				placeholder: "Powered By EasyMDE. HTML also supported", 
				hideIcons: ['fullscreen'],
				sideBySideFullscreen: false, 
				maxHeight: '350px', 
				uploadImage: true,
				imageUploadEndpoint: 'api/imgur_upload.php'
			});
			
			md.toggleSideBySide();


			function FileBrowse(){
				$('#file_browser').trigger('click');
				return false;
			}
			


			$("#file_browser").change(function(){
				$('#shortlinker').prop('disabled', true);
				$('input[name="postImage"]').prop('disabled', true);
				$('input[name="postImage"]').prop('placeholder', 'Uploading and fetching link....');
				
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
							$('input[name="postImage"]').prop('placeholder', 'Uploaded Succesfully');
							$('input[name="postImage"]').val(response.data.filePath);
						}
					},
					error: function(err){
						$('input[name="postImage"]').prop('placeholder', 'Error Occured'+err.responseJSON.error);
					},

					complete: function(){
						$('input[name="postImage"]').prop('disabled', false);
						$('#shortlinker').prop('disabled', false);
					}
				});
        	});

		</script>


	</body>
</html>