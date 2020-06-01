<?php 
require_once("./includes/config.php");		

if(isset($_POST['comment_submit']) && !empty($_POST['comment']) && isset($_GET['pid']) && isset($_SESSION['user']))
{	
	unset($_POST['comment_submit']);
	$comment = str_replace("}}:{{", ' ', trim(preg_replace('/\s+/', ' ', nl2br(sanitizeString($_POST['comment'])))));
	$filename = sanitizeString($_GET['pid']).'-comments';
	$commentfile = fopen(ROOT_PATH."/uploads/blog_comments/${filename}.txt", 'a');
	fwrite($commentfile, $_SESSION['user']['id'].'}}:{{'.$comment.'}}:{{'.time()."\r\n");
	fclose($commentfile);
	header("refresh: 0");
	exit();
}

if(isset($_POST['cnf_delete']) && isset($_GET['pid']) && isset($_SESSION['user']) && ($u == $user['id'] || $user['id']==1))
{	
	unset($_POST['cnf_delete']);
	unset($_POST['post_delete']);

	$filename = sanitizeString($_GET['pid']);

	try{
		getDBconn()->exec("DELETE FROM blog WHERE blog_id='$filename'");

		if(file_exists(ROOT_PATH."/uploads/blog_comments/${filename}-comments.txt")) {  
			unlink(ROOT_PATH."/uploads/blog_comments/${filename}-comments.txt");
		}
		if(file_exists(ROOT_PATH."/uploads/blog/${filename}.md"))
		{
			unlink(ROOT_PATH."/uploads/blog/${filename}.md");
		}
	}catch(Exception $e)
	{
		die('Error Occured While Deleting: '.$e);
	}
	

	header("location: ./index.php");
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
                    $post = getDBconn()->prepare('SELECT * FROM blog WHERE blog_id=?');
					
					if($post->execute([$pid]) && $post = $post->fetch())
                    { 
						?>

					<?php 
					$u = explode('_', $pid)[0];
					
					if(!(isset($_POST['post_delete']) || isset($_POST['post_edit'])))
					{
						
						if($u == $user['id'] || $user['id']==1)
						{
						?>
						<div class="d-flex flex-row justify-content-end">
							<form method="POST">
								<button type="submit" name="post_edit" class="btn btn-warning m-2"><i class="fa fa-pencil"></i> Edit</button>
							</form>
							<form method="POST">
								<button type="submit" name="post_delete" class="btn btn-danger m-2"><i class="fa fa-trash"></i> Delete</button>
							</form>
						</div>	
					<?php
						}
						else
						{?>
							<div class="d-flex flex-row justify-content-end">
								<form method="POST">
									<button type="submit" name="post_report" class="btn btn-warning m-2"><i class="fa fa-ban"></i> Report</button>
								</form>
							</div>
							
						<?php
						}
					}?>
	
					<div class="jumbotron display-4"><?php echo $post['heading'];?></div>
					
						
					<?php 
					if(($u == $user['id'] || $user['id']==1) && isset($_POST['post_delete']))
					{
					
						echo '<div class="text-center">
							<form method="POST">
								<label for="cnf_delete">Are You Sure You Want to Delete this Post :- </label>
								<button type="submit" name="cnf_delete" class="btn btn-danger m-2"><i class="fa fa-exclamation-circle"></i> Yes</button>
								<button type="submit" name="" class="btn btn-primary m-2"><i class="fa fa-check"></i> No</button>
							</form>
						</div>';
						
					}
					else
					{

					?>	
						
						   <hr>
		
						   <div id="blogcontent">
                        		<?php printContents($post['blog_id']) ?>
							</div>
							<br><br><br>

							<hr class="bg-white">
							<form method="POST">
								<div class="form-group container">
									<label for="comment"></label>
									<textarea class="form-control" name="comment" placeholder="Leave A Comment" rows="3" required></textarea>
									<button type="submit" name="comment_submit" class="mt-3 btn btn-primary"><i class="fa fa-comment"></i> Add</button>
								</div>
							</form>

						
						<?php
							CommentsArea($post['blog_id']);
						}	
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
				$(this).attr("title", "<?=$post['heading'];?>-Intragram");
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
		echo (isset($_POST['comment_submit']) && !empty($_POST['comment']) && isset($_GET['pid']) && isset($_SESSION['user']));
		
		$allComm = file(ROOT_PATH."/uploads/blog_comments/${pid}-comments.txt");
		?>
			<?php for($i=0;$i<count($allComm);$i++)
			{
				$com = explode("}}:{{", $allComm[$i]);
				$userdet = getDBconn()->query('SELECT name, username, profile_pic FROM users WHERE id='.$com[0])->fetch();
				
				$time = new DateTime("@$com[2]");
				?>
				<div class="d-flex flex-row border mb-3">
					<div class="p-2 bd-highlight"><a href="./profile.php"><img class="rounded-circle img-fluid" style="width: 64px;height: 64px;" src="<?=$userdet['profile_pic']?>"></a></div>
					<div class="p-2 border-left flex-grow-1">
						<div class="card-text"><?=$com[1]?></div>
						<div class="text-right card-footer"><?=$time->format('d-M-Y h:m A')?></div>
					</div>
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