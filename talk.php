<?php 
	require_once("./includes/config.php");



	//Chatbox



	//EndChatbox







	if(!isset($_SESSION['user']))
	{
		header('location: login.php');
		exit();
	}
	$user = $_SESSION['user'];
	$uid = $user['id'];


//Searching
	if(isset($_GET['rec']) && !empty($_GET['rec']))
	{
		$rec = sanitizeString($_GET['rec']);	
		$toid = getDBconn()->query("SELECT id FROM users WHERE username='$rec'")->fetchColumn();	
		$uid = $user['id'];
	
		if($toid == $uid || empty($toid))
		{	
			header('location: '.$_SERVER['PHP_SELF']);
			exit();
		}else{
			$arr = [$uid, $toid]; 
			sort($arr);
		}
	}

	
// Sending Messages
		
?>
<!DOCTYPE HTML>
<html>

<head>
	<title>Intragram-Talk</title>
	<?php require_once("./includes/includers.php"); ?>
</head>

<body>

	<?php require_once("./includes/header.php");?>
	

			<section class="forms">
			<br /><br /><br />

			<?php
						
				
				


			?>
				<div class="container pt-3">
				<div class="row">

					<div class="col-md-5 mb-3">
						<div class="bg-primary rounded" style="height: 440px;">
							<div>
								<form class="px-4" method="GET">
									<div class="form-group">
										<label for="searchUser"></label>
										<input type="text" class="form-control" placeholder="Search By Username" name="searchUser" required>
									</div>
									<button type="submit" name="searchUser_submit" class="btn btn-theme">Search</button>	
								</form>
							</div>

							<div id="searchedUsers" class="m-3 overflow-auto">
								<?php 
								if(isset($_GET['searchUser_submit']) && !empty($_GET['searchUser']))
								{		
									$term = sanitizeString($_GET['searchUser']);
									userSearch(getDBconn(), $term);								
								}
								else
								{
									if(isset($toid))
									{
										getMiniProfile(sanitizeString($toid));
									}
									else
									{
										echo '<div class="text-center bg-danger">Search Username First</div>';
									}
									
								}
								?>
							</div>
						</div>
					</div>
					<div class="col-md-7 container">
						<div id="chatbox" class="bg-warning rounded overflow-auto" style="height: 325px">
							<?php 
							// Viewing Chatbox
							if(isset($toid))
							{
							
								if(file_exists(ROOT_PATH."/chats/".$arr[0]."_".$arr[1].".txt"))
								{		
									$chatfile = fopen(ROOT_PATH."/chats/".$arr[0]."_".$arr[1].".txt", 'r');								
									while ($line = fgets($chatfile, 1024)) 
									{ 						
										$messageArr = explode('}}:{{', $line);
										$author = $messageArr[0];
										$message = $messageArr[1];
										
										if($author==$uid)
										{
											$bg = 'bg-primary text-right';
											$aname = 'You';
										}else{
											$aname = getDBconn()->query("SELECT name FROM users WHERE id='$author'")->fetchColumn();
											$bg = 'bg-dark text-left';
						
										}
										echo '<div class="m-3 p-2 rounded '.$bg.'">
												<div class="">'.$message.'</div>
												<small class="blockquote-footer text-warning">'.$aname.'</small>
											</div>';
									}
									fclose($chatfile);

								}
								else
									echo '<div class="text-center h-100 bg-danger p-4">No Messages, Say Hi to start a conversation.</div>';			

							}
							else
							{
								echo '<div class="w-100 h-100 bg-danger text-center">To Chat, search and select a Username</div>';
							}
								

								
							?>
						</div>

						
						<form id="chatform" autocomplete="off" action="api/talk_api.php" method="POST">
							<fieldset<?php echo (!isset($toid)?' disabled':'');?>>
							<div class="form-group">
								<label for="chatMessage"></label>
								<input type="text" class="form-control" placeholder="Write Your Message" name="chatMessage" required>
								<input type="number" name="toid" value="<?=$toid?>" hidden>
								<input type="number" name="uid" value="<?=$uid?>" hidden>
							</div>
							<button type="submit" id="send_message" name="message_submit" class="btn btn-theme">Send</button>
							</fieldset>
						</form>
						
					</div>
				</div>		
				</div>
				<br><br>
			</section>






	<?php require_once("./includes/footer.php");?>

	<script>




		$(document).ready(()=>{

			$('#chatbox').scrollTop($('#chatbox')[0].scrollHeight);

			$("#send_message").click(function (event) {
		        event.preventDefault();

		        if($('input[name=chatMessage]').val() == '')
		        	return false;

		        $('button[name=message_submit]').attr('disabled', true);
				$('button[name=message_submit]').html('Sending...');

				
		        var form = $('#chatform').serialize() + '&ajx=true';
		        
		        $.ajax({
		        	type: "POST",
		        	url: "api/talk_api.php",
		        	data: form,
		        	cache: false,

		        	success: function(ans){
		        		if(ans=="Success")
		        			$('#chatbox').append('<div class="m-3 p-2 rounded bg-primary text-right"><div class="">'+$('input[name=chatMessage]').val()+'</div><small class="blockquote-footer text-warning">You</small></div>');
		        		$('input[name=chatMessage]').val('');
		        	},

		        	complete: function(){
		       			$('#chatbox').scrollTop($('#chatbox')[0].scrollHeight);
		       			$('button[name=message_submit]').attr('disabled', false);
				 		$('button[name=message_submit]').html('Send');
		        	}		        	
		        });
		        return false;
		    });
			
			

		});




	
	</script>
</body>

</html>



<?php 
	function userSearch($connection, $term)
	{
		$quer = $connection->prepare('SELECT id, name, username, profile_pic FROM users WHERE username LIKE :term');
		echo '<div class="p-2 m-2 rounded bg-dark">Searching :- \''.$term.'\'</div>';
		if($quer->execute([":term"=> "%".$term."%"]))
		{
			while($d = $quer->fetch())
			{
				if($d['id']==$_SESSION['user']['id'])
					continue;
				echo '<div class="p-3 border m-2"><a href="'.$_SERVER['PHP_SELF'].'?rec='.$d['username'].'">'.$d['username'].'</a></div>';
			}
		}
		else
		{
			echo 'Some Error Occured!';
		}
	}


	function getMiniProfile($prof)
	{
		$reci = getDBconn()->prepare("SELECT name, username, about, profile_pic FROM users WHERE id=?");
		if($reci->execute([$prof]))
		{
			$reci = $reci->fetch();
			?>
			<div class="mini-profile text-center pt-4 border">
				<div class="profile-pic">
				<img class="img-fluid rounded-circle bg-dark p-2" src="<?php echo $reci['profile_pic'];?>" style="height: 128px; width: 128px;" onerror="this.src='images/no-image.png';" />
				</div>
				<div class="profile-detail pt-2">
					<h2><?php echo $reci['name'];?></h2>
					<h3><?php echo $reci['username'];?></h3>
					<h4><?php echo $reci['about'];?></h4>
				</div>	
			</div>
		<?php
		}
		else
		{
			echo 'Error Occured';
		}
		?>
	<?php
	}
?>


