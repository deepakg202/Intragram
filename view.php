<!DOCTYPE HTML>
<html>
	<head>
		<title>Intragram-View</title>
		<?php require_once("./includes/config.php");?>
		<?php require_once("./includes/includers.php"); ?>
	</head>
	<body>
		
		<?php require_once("./includes/header.php");?>
		<br /><br /><br /><br /><br />
		<?php
		if(isset($_SESSION['user']) && isset($_GET['pid'])){ 
			$user = $_SESSION['user'];
			$name = $user['Name'];
			$desig = $user['Designation'];
			$branch = $user['Branch'];
			?>
		
		<section id="viewPost" class="pt-3">
			<div class="container">
                <?php 
                    $pid = sanitizeString($_GET['pid']);
                    $post = getDBconn()->prepare('SELECT * FROM blog WHERE BlogId=?');
                    if($post->execute([$pid]) && $post = $post->fetch())
                    { ?>

                        <div class="jumbotron display-4"><?php echo $post['Heading'];?></div>
                       
                        <?php
                        printContents($post['BlogId']);
                    }
                    else
                    {
                        echo '<div class="jumbotron">Post Not Found </div>';
                        echo '<br><br><br>';
                        header('./index.php');
                    }
                ?>

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