<!DOCTYPE HTML>
<html>

<head>
	<title>Intragram</title>
	<?php require_once("./includes/config.php");?>
	<?php require_once("./includes/includers.php"); ?>
</head>

<body>

	<?php require_once("./includes/header.php");?>
	
	<?php
		if(isset($_SESSION['user'])){ 
			$user = $_SESSION['user'];
			$name = $user['Name'];
			$desig = $user['Designation'];
			$branch = $user['Branch'];
	?>

			<section class="forms" id="chat">
			<br /><br /><br /><br /><br />
				<div class="container form-inner p-4 rounded">
					<div id="chatbox" class="bg-warning rounded" style="height: 250px;overflow: auto">
						<?php 
							$uid = $_SESSION['user']['id'];
							$toid = 3;
							$arr = [$uid, $toid]; 
							sort($arr);
							if(file_exists(ROOT_PATH."/chats/".$arr[0]."_".$arr[1].".txt"))
							{		
								$chatfile = fopen(ROOT_PATH."/chats/".$arr[0]."_".$arr[1].".txt", 'r');								
								while ($line = fgets($chatfile, 1024)) { 
									
									$messageArr = explode('}}:{{', $line);
									$author = $messageArr[0];
									$message = $messageArr[1];
									
									$bg = 'bg-dark text-left';
									if($author==$uid)
									{
										$bg = 'bg-primary text-right';
										$aname = 'You';
									}else{
										$aname = getDBconn()->query("SELECT Name FROM users WHERE id='$author'")->fetchColumn();
									}
									echo '<div class="m-3 p-2 rounded '.$bg.'">
											<div class="">'.$message.'</div>
											<small class="blockquote-footer text-warning">'.$aname.'</small>
										</div>';
								}

								fclose($chatfile);

							}
							else
								echo '<div class="text-center p-4">No Messages</div>';			


							
						?>
					</div>

					<?php
					if(isset($_POST['message_submit']) && !empty($_POST['chatMessage']))
					{
						$uid = $_SESSION['user']['id'];
						$toid = 3;
						$arr = [$uid, $toid]; 
						sort($arr);
						$chatfile = fopen(ROOT_PATH."/chats/".$arr[0]."_".$arr[1].".txt", 'a');
						$chatMessage = str_replace("}}:{{", " ", sanitizeString($_POST['chatMessage']));
						fwrite($chatfile, ''.$uid.'}}:{{'.$chatMessage.''."\r\n");
						fclose($chatfile);		
						unset($_POST);
						header('location: '.$_SERVER['PHP_SELF']);
						die();
					}	
					?>
					<form id="chatform" autocomplete="off" method="POST">
						
						<div class="form-group">
							<label for="chatMessage"></label>
							<input type="text" class="form-control" placeholder="Write Your Message" name="chatMessage" required>
						</div>
						<button type="submit" name="message_submit" class="btn btn-theme">Submit</button>
					</form>
					
				</div>		
				<br><br>
				<br><br>
				<br><br>
			</section>



	


	<?php 
	}
		else{
			header('location: ./login.php');
		}
	?>



	<?php require_once("./includes/footer.php");?>

	<script>
		$('#chatbox').scrollTop($('#chatbox')[0].scrollHeight);
	</script>
</body>

</html>

