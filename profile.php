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
			$name = $user['Name'];
			$desig = $user['Designation'];
			$branch = $user['Branch'];
			?>

	<section id="profile" class="pt-3">
		<div class="container">
			<div class="row">
				<div class="col-md-3">

					<div class="sticky-top" style="top: 100px;">

						<div class="profile-pic">
							<img class="img-fluid rounded bg-white p-2" src="./images/user.png">
						</div>


						<div class="profile-detail pt-2">
							<h2><?php echo $name;?></h2>
							<h3><?php echo $desig;?></h3>
							<h4><?php echo $branch;?></h4>
						</div>
						<br />
						<div class="profile-nav py-3">
							<div class="d-flex flex-md-column flex-sm-row justify-content-around">
								<a class="p-2 active-nav" href="index.php"><span class="fa fa-user fa-fw"></span>
									Overview</a>
								<a class="p-2" href="log.php"><span class="fa fa-list-alt fa-fw"></span> Activity
									Log</a>
								<a class="p-2" href="settings.php"><span class="fa fa-cog fa-fw"></span> Settings</a>
							</div>
						</div>

					</div>
				</div>

				<div class="col-md-9 container">

					<!-- Blog Posts -->


                    <?php 
                            $posts = getDBconn()->query("SELECT COUNT(*) FROM blog WHERE UserId = {$user['id']}")->fetchColumn();
							$postPerPage = 2;
							$totalPages = ceil($posts/$postPerPage);
							
							if (isset($_GET['page']) && is_numeric($_GET['page'])) {
								$currentpage = (int) sanitizeString($_GET['page']);
							} else {
								$currentpage = 1;
							} 

							if ($currentpage > $totalPages) {
								$currentpage = $totalPages;
							}

							if ($currentpage < 1) {
								$currentpage = 1;
							}

							$offset = ($currentpage - 1) * $postPerPage;


							printBlog(getDBconn(), $offset, $postPerPage);
							blogNav($currentpage, $totalPages);
				
							
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
	<a type="button" class="postBtn position-sticky p-4 float-right btn btn-warning rounded-circle" href="add.php"><i
			class="fa fa-2x fa-plus-circle"></i></a>

	<!-- END NEW POST BUTTON -->



	<br><br>
	<br><br>
	<br><br>
	<?php require_once("./includes/footer.php");?>
</body>

</html>






<?php 
    function printBlog($connection, $offset, $postPerPage)
    { 
        
        $blogData = getDBconn()->prepare("SELECT * FROM blog ORDER BY Created DESC LIMIT $offset, $postPerPage ");
        $blogData->execute();
        $blogData = $blogData->fetchAll();
        
        for($i=0;$i < count($blogData);$i++){
            $uid = $blogData[$i]['UserId'];    
            $name = $connection->query("SELECT Name FROM users WHERE id= $uid")->fetchColumn();
            
            $filename = $blogData[$i]['BlogId'];
            
            if(!file_exists(ROOT_PATH.'/uploads/blog/'.$filename.'.md'))
                continue;
            
            
        ?>


	<div class="card text-dark p-1 mb-4">
		<div class="card-header clearfix">
			<div class="float-left">Posted By: <?php echo $name;?></div>
			<div class="float-right"><?php echo $blogData[$i]['Created']?></div>
		</div>
		<a href="./view.php?pid=<?php echo $filename; ?>" style="color:unset; text-decoration: unset;">
			<img class="card-img" src="https://via.placeholder.com/1366x768" alt="Card image">
			<div class="card-body">
				<h5 class="card-title"><?php echo $blogData[$i]['Heading'];?></h5>
				<p class="card-text">
					Click to View Post
				</p>
			</div>
		</a>
		<br>
		<div class="card-footer d-flex justify-content-around text-center">
			<a href="#" class="btn "><i class="fa fa-thumbs-up"></i> Like</a>

			<a href="#" class="btn"><i class="fa fa-comment"></i> Comment</a>

			<a href="#" class="btn"><i class="fa fa-paperclip"></i> Share</a>
		</div>
	</div>

<?php
    }
}


	function blogNav($currentpage, $totalPages)
	{?>

<nav aria-label="blog-nav">
	<ul class="pagination justify-content-center">
		<li class="page-item <?php echo ($currentpage == 1)?'disabled':'' ; ?>">
			<a class="page-link" href="?page=<?php echo $currentpage-1;?>" aria-label="Previous">
				<span aria-hidden="true">&laquo;</span>
				<span class="sr-only">Previous</span>
			</a>
		</li>

		<?php 
		for($i=1;$i<=$totalPages;$i++)
		{
		
			if($i == $currentpage)
			{?>
				<li class="page-item active"><a class="page-link" href="#"><?php echo $i;?></a></li>
			<?php
			}
			else
			{
			?>
		<li class="page-item"><a class="page-link" href="?page=<?php echo $i;?>"><?php echo $i;?></a></li>

		<?php
			}
			
		}
		?>

		<li class="page-item  <?php echo ($currentpage == $totalPages)?'disabled':'' ; ?>">
			<a class="page-link" href="?page=<?php echo $currentpage+1;?>" aria-label="Next">
				<span aria-hidden="true">&raquo;</span>
				<span class="sr-only">Next</span>
			</a>
		</li>
	</ul>
</nav>


<?php
	}
?>