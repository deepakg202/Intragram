<?php 
require_once("./includes/config.php");		

if(isset($_POST['comment_submit']) && !empty($_POST['comment']) && isset($_GET['pid']) && isset($_SESSION['user']))
{
	unset($_POST['comment_submit']);
	$comment = str_replace("}}:{{", ' ', trim(preg_replace('/\s+/', ' ', nl2br(sanitizeString($_POST['comment'])))));
	$filename = sanitizeString($_GET['pid']).'-comments';
	$commentfile = fopen(ROOT_PATH."/uploads/blog_comments/${filename}.txt", 'a');
	fwrite($commentfile, $_SESSION['user']['id'].'}}:{{'.$comment."\r\n");
	fclose($commentfile);
	header("refresh: 0");
	exit();
}

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Intragram-View</title>
		<?php require_once("./includes/includers.php"); ?>
	</head>
	<body>
		
		<?php require_once("./includes/header.php");?>
		<br /><br /><br /><br /><br />
		
		<?php
		if(isset($_SESSION['user']) && isset($_GET['pid'])){ 
			$user = $_SESSION['user'];
			
			?>
		
		<section id="viewPost" class="pt-3">
			<div class="container">
                <?php 
                    $pid = sanitizeString($_GET['pid']);
                    $post = getDBconn()->prepare('SELECT * FROM blog WHERE BlogId=?');
                    if($post->execute([$pid]) && $post = $post->fetch())
                    { ?>

                        <div class="jumbotron display-4"><?php echo $post['Heading'];?></div>
						   <hr>
		
						   <div id="blogcontent">
                        		<?php printContents($post['BlogId']) ?>
							</div>
							<br><br><br>
						<hr class="bg-white">
						<form method="POST">
							<div class="form-group container">
								<label for="comment"></label>
								<textarea class="form-control" name="Comment" placeholder="Leave A Comment" rows="3"></textarea>
								<button type="submit" name="comment_submit" class="mt-3 btn btn-primary"><i class="fa fa-comment"></i> Add</button>
							</div>
						</form>

						
						<?php
							CommentsArea($post['BlogId']);
					}
                    else
                    {
                        echo '<div class="jumbotron display-4"><div id="blogcontent">Post Not Found </div></div>';
                        echo '<br><br><br>';
            		}
                ?>
				
			</div>
		</section>
		<?php }
		else{
			if(!isset($_GET['pid']))
			{
				header("location: ./index.php");
			}
			?>
				<div class="container jumbotron display-4">
					<div id="blogcontent"><a href="./login.php">Login</a> To View Content</div>
				</div>

			<?php
			
		}
		?>
	
		<br><br>
		<br><br>
		<br><br>
		<?php require_once("./includes/footer.php");?>
			
		<script type="text/javascript">
			$(document).ready(function() {
				$(this).attr("title", "<?=$post['Heading'];?>-Intragram");
			});
		</script>
	</body>
</html>


<?php 

function printContents($pid)
{
	require_once("./includes/Parsedown.php");
	$Parsedown = new Parsedown();
	?>
	
	<div class="content">
		<?php echo $Parsedown->text(file_get_contents(ROOT_PATH.'/uploads/blog/'.$pid.'.md'));?>
	</div>
	
	<?php
}

function CommentsArea($pid)
{
	if(file_exists(ROOT_PATH."/uploads/blog_comments/${pid}-comments.txt"))
	{
		echo '<br><div class="container mt-4" id="comments">';
		
		$allComm = file(ROOT_PATH."/uploads/blog_comments/${pid}-comments.txt");
		?>
			<?php for($i=0;$i<count($allComm);$i++)
			{
				$com = explode("}}:{{", $allComm[$i]);
				$userdet = getDBconn()->query('SELECT Name, Username, ProfilePic FROM users WHERE id='.$com[0])->fetch();
				
				?>
				<div class="d-flex flex-row border my-3">
					<div class="p-2 bd-highlight"><a href="./profile.php"><img class="rounded-circle img-fluid" style="width: 64px;height: 64px;" src="<?=$userdet['ProfilePic']?>"></a></div>
					<div class="p-2 flex-grow-1 border-left p-1"><?=$com[1]?></div>
				</div>
			<?php
			}?>
		

<?php
	}
	else
	{
		echo '<br><br><h3 class="container">Be The First To Comment.</h3>';
	}
	echo '</div>';
}

?>